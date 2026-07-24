# Automation & Workflow Engineering — BerChain e.V.

**Role:** Automation & Web Developer (Volunteer / NGO Contributor)<br>
**Organization:** BerChain e.V. — Berlin's Blockchain Association<br>
**Location:** Berlin, Germany<br>
**Tech Stack:** n8n · WordPress · OpenAI API · Notion API · Slack API · Google APIs · BrightData · Apify · Telegram Bot API · PHP · RSS

---

## Overview

Designed, built, and maintained a suite of automated data pipelines and content workflows for BerChain, Berlin's leading blockchain industry association. The system aggregates events, job postings, and industry news from multiple external sources; stores and curates them in a central Notion database; publishes them to the BerChain website and Slack community channels; and generates AI-assisted LinkedIn content for the association's social media presence — all with minimal manual intervention.

---

## System Architecture

The automation stack is built on **n8n** and consists of loosely coupled, independently scheduled workflows. Notion serves as the central data hub. External data is ingested via web scraping and APIs, normalized, deduplicated, and then distributed to downstream systems (WordPress, Slack, Google Calendar, LinkedIn).

```
External Sources                Central Hub          Distribution
─────────────────────────────────────────────────────────────────
Lu.ma / Meetup (events)    ──►
LinkedIn / Glassdoor /
  Indeed / CryptoJobsList  ──►  Notion Databases  ──►  WordPress (website)
Company Websites /               (Events, Jobs,         Slack (community)
  LinkedIn Posts            ──►   News, Companies)  ──►  Google Calendar
Google News RSS             ──►                     ──►  LinkedIn (posts)
```

---

## Workflows Built

### 1. Event Aggregation & Distribution

#### What it does

Automatically discovers Berlin blockchain events from Lu.ma and Meetup on a recurring schedule, stores them in a Notion database, syncs them to Google Calendar, and notifies the community via Slack.

#### How it works

**Ingestion (Lu.ma & Meetup)**

- A schedule trigger fires every 3 days.
- Performs HTTP requests to the Lu.ma and Meetup APIs/calendar endpoints to fetch upcoming events.
- Raw HTML/JSON is parsed with custom JavaScript to extract structured event data (title, date, location, URL, description).
- An AI Information Extractor node (`gpt-4o-mini`) identifies event themes and categories from unstructured event descriptions.
- Each event is checked against the Notion database for duplicates before being saved, preventing re-insertion of already-tracked events.

**Google Calendar Sync**

- A Notion trigger fires whenever a page is updated in the Events database.
- If the event is marked as `Published`, it is created or updated in Google Calendar via the Google Calendar API.
- Handles both single-date and multi-date (end date) events.
- If an event is unpublished or removed from Notion, the corresponding Google Calendar entry is also deleted — keeping both systems in sync bidirectionally.

**Slack Notifications**

- Two separate schedules:
  - **Every 3 days:** Posts newly added or updated events to the `#events` Slack channel via webhook.
  - **Every Monday at 09:00:** Posts a curated digest of that week's upcoming events to the community channel using the Slack `chat.postMessage` API (Bearer token auth), and automatically **pins** the message to keep it visible.
- Event data is formatted with emojis and structured text using a custom JavaScript formatter that localizes timestamps to the `Europe/Berlin` timezone.

#### Key techniques

- Idempotent ingestion (duplicate check before insert)
- Bidirectional sync between Notion and Google Calendar
- Timezone-aware date formatting (`Europe/Berlin`)
- Slack message pinning via `pins.add` API call

---

### 2. Job Posting Aggregation & Distribution

#### What it does

Scrapes blockchain/crypto-related job postings from LinkedIn, Glassdoor, Indeed, and CryptoJobsList. Normalizes and stores them in Notion. Serves them via an internal API and notifies the Slack community every three days.

#### How it works

**Multi-source scraping (LinkedIn, Glassdoor, Indeed)**

- Uses the **BrightData API** to programmatically trigger scraping jobs against LinkedIn, Glassdoor, and Indeed.
- Implements an **asynchronous polling pattern**: after submitting a scrape request, the workflow waits and polls a status endpoint on a delay loop until the scraping job reports as complete.
- Once data is ready, a `snapshotId` is used to fetch the scraped results.
- All three source results are merged into a single stream and processed uniformly.

**CryptoJobsList**

- Consumes the CryptoJobsList RSS feed via a recurring trigger.
- For each new job posting link, fetches the full job page via HTTP and parses the embedded `__NEXT_DATA__` JSON (a Next.js SSR pattern) to extract structured job details.
- Filters results to include only Berlin-based or Remote positions.

**Deduplication & Storage**

- Before inserting, each job is queried against the Notion Jobs database by job title and company name.
- If a matching entry already exists, it is first archived and then re-created with updated data — effectively an upsert pattern.
- Stored fields include: job title, company, location (multi-select), job type (full-time/part-time/internship — normalized via conditional logic), job description, application link, post URL, source platform, and date posted.

**Internal REST API**

- Exposes a webhook-based HTTP GET endpoint that queries the Notion Jobs database, filters out expired and archived entries, sorts results by creation date (descending), and returns clean JSON.
- This API was consumed by the WordPress frontend to display live job listings on the BerChain website.

**Slack Notifications**

- Scheduled every 3 days at 09:00.
- Queries Notion for jobs added in the last 3 days, filters for non-expired listings, sorts by recency, and posts a formatted digest to the `#jobs` Slack channel via webhook.

#### Key techniques

- Async polling loop for BrightData scraping jobs
- Next.js `__NEXT_DATA__` extraction for SSR pages
- Upsert pattern (archive old → create new) in Notion
- Internal webhook API serving data to WordPress

---

### 3. Company News Scraping & Publishing

#### What it does

Monitors the LinkedIn pages of companies in BerChain's network, scrapes their recent posts, stores them in Notion as news items, and exposes them via a REST API for the WordPress website.

#### How it works

- Uses the **Apify LinkedIn Post Scraper** (via HTTP API) to extract recent posts from company LinkedIn pages.
- Scraped posts are processed and saved to the Notion News database.
- Two webhook endpoints are exposed:
  - A **feed endpoint** that returns a sorted list of news items (title + ID).
  - A **detail endpoint** that accepts a `?id=` query parameter, fetches the full Notion page and its child blocks (article content), filters for non-empty blocks, and returns the full content for rendering on the website.

---

### 4. Company Profile Update Automation

#### What it does

Periodically crawls the official websites and LinkedIn profiles of companies in BerChain's database and uses AI to detect and apply meaningful profile updates.

#### How it works

- Iterates over all companies in the Notion database in batches.
- For each company, runs two parallel scraping branches:
  - **Website crawl:** Validates the company URL, then calls a web crawling POST API to retrieve page content. Waits for completion and fetches the result.
  - **LinkedIn scrape:** Uses **BrightData** with the same async polling pattern (submit → poll status → fetch snapshot) to retrieve the company's LinkedIn posts.
- Both results are merged and aggregated into a single text blob.
- The combined text is sent to an **AI Agent** (`gpt-4o-mini` via LangChain) with a custom system prompt instructing it to compare the scraped content against the existing Notion data and identify new, changed, or additional information.
- If the AI detects meaningful updates, it outputs a structured diff and the Notion page is updated accordingly.
- Includes duplicate removal to handle overlapping data from multiple sources.

#### Key techniques

- Parallel scraping branches (website + LinkedIn) with merge
- AI-powered change detection (compare old vs. new data)
- Custom prompting for structured output (system message + user message authored from scratch)

---

### 5. AI-Powered LinkedIn Post Generation & Approval

#### What it does

Automatically drafts LinkedIn posts for BerChain's official account using AI, routes them through a human-in-the-loop approval process via Telegram, and publishes approved posts directly to LinkedIn.

#### How it works

**Content sourcing**

- Reads a list of target topics/keywords from a **Google Sheet**.
- Fetches Berlin blockchain news via two **RSS feeds** (Google News - blockchain + crypto).
- Decodes Google News redirect URLs to extract the original article URLs.
- Also scrapes recent **LinkedIn posts** from relevant accounts using the Apify LinkedIn Post Scraper for additional context.

**AI drafting**

- All fetched articles and posts are aggregated and passed to an **AI Agent** (`gpt-4o-mini` with LangChain).
- The agent uses a **Structured Output Parser** to return a consistent JSON schema: extracted keywords, a draft LinkedIn post body, and a suggested hashtag set.
- The system message and user prompt were written entirely from scratch to match BerChain's voice and format requirements.
- A second AI Agent pass refines the draft based on LinkedIn post examples for style consistency.

**Human-in-the-loop approval via Telegram**

- The draft post is sent to the designated administrator via the **Telegram Bot API**.
- The admin reviews the draft and replies with one of three commands: **Approve**, **Revise**, or **Cancel**.
- A `Wait` node pauses the workflow indefinitely until a Telegram response is received (webhook-based resume).
- If **Approve**: the post is published directly to LinkedIn and the Google Sheet row is updated to `Published`.
- If **Revise**: the admin's feedback is written back to the Google Sheet, and the AI re-drafts the post incorporating the revision notes.
- If **Cancel**: the row is marked as `Cancelled` in the Google Sheet.

#### Key techniques

- RSS feed parsing + URL decoding for Google News redirect links
- Multi-agent AI pipeline (draft → refine)
- Structured output parsing (enforced JSON schema from LLM)
- Human-in-the-loop via Telegram webhook with conditional branching
- Direct LinkedIn publishing via API

---

### 6. Error Monitoring & Alerting

#### What it does

Provides centralized error monitoring across all workflows. When any workflow fails, an automatic alert is sent to a designated Slack channel.

#### How it works

- Uses n8n's built-in error trigger, which fires whenever a connected workflow throws an unhandled error.
- Sends a formatted Slack message via webhook containing: workflow name, error description, and the name of the node that failed.
- All production workflows reference this as their shared error handler, making it a global monitoring layer.

---

## WordPress Integration

- Modified the BerChain website UI (theme customizations, layout adjustments).
- Built custom **PHP scripts** that consume the internal n8n webhook APIs and render the data as dynamic WordPress posts.
- Used the **WordPress REST API** in combination with an API plugin to create and update job and news posts programmatically from n8n workflows — enabling fully automated content publishing to the public website without manual CMS intervention.

---

## APIs & Services Used

| Service                        | Usage                                                                   |
| ------------------------------ | ----------------------------------------------------------------------- |
| **OpenAI API** (`gpt-4o-mini`) | LLM for content generation, information extraction, change detection    |
| **Notion API**                 | Central database for events, jobs, news, company profiles               |
| **Slack API**                  | Community notifications, error alerting, message pinning                |
| **Google Calendar API**        | Event sync from Notion                                                  |
| **Google Sheets API**          | LinkedIn post approval tracking and topic management                    |
| **BrightData API**             | Scalable web scraping for LinkedIn, Glassdoor, Indeed, company websites |
| **Apify API**                  | LinkedIn post scraping                                                  |
| **Telegram Bot API**           | Human-in-the-loop approval flow for LinkedIn content                    |
| **WordPress REST API + PHP**   | Automated content publishing to the BerChain website                    |
| **RSS**                        | Berlin blockchain news ingestion from Google News                       |
| **Lu.ma / Meetup APIs**        | Event discovery and ingestion                                           |
| **CryptoJobsList RSS**         | Crypto job posting ingestion                                            |

---

## Relevance to Bundesblock e.V.

The workflows built at BerChain cover the same core operational needs Bundesblock has just at a larger scale.

### Events

- Bundesblock regularly runs working group sessions, public meetups, and conferences like Proof of Talk.
- The event scraping, Google Calendar sync, and weekly Slack digest could be adapted to cover Bundesblock's event calendar and keep members across all Landesgruppen up to date.

### Ecosystem and member tracking

- Bundesblock maintains a Web3 Ecosystem Map of the DACH region and tracks over 90 member organizations.
- The company profile update automation crawls member websites and LinkedIn pages, uses AI to spot new or changed information, and updates the database automatically. This could replace a lot of the manual research currently needed to keep the member database current.

### Talent and jobs

- Helping members find employees, freelancers, and service providers is listed as one of Bundesblock's core membership benefits.
- The job scraping pipeline (LinkedIn, Glassdoor, Indeed, CryptoJobsList) and Slack notification system could be extended to cover the national market for Bundesblock's full member network.

### Content and social media

- Bundesblock publishes position papers, statements, and news through its website, newsletter, and LinkedIn.
- The LinkedIn post generation workflow pulls in relevant news via RSS, drafts a post using GPT-4o-mini, and sends it to an admin for approval before anything goes live. That approval step matters for an organization where public statements go through editorial review.

### Working group news monitoring

- Each of Bundesblock's working groups covers a specific area like DAOs, Digital Euro, DeFi, or Supply Chain.
- The LinkedIn news scraping pipeline could be set up per working group to track relevant companies, publications, and regulators and surface updates into a shared database.

### Infrastructure

- Bundesblock already uses Slack as its main communication platform, so the error monitoring and overall workflow setup would fit in without any additional tooling.
