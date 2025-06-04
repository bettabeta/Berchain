<?php
/**
 * Template Name: Events Template
 * Template Post Type: page
 */
get_header();
?>

<div class="events-list">
  <div class="wrap">
    <h2>Upcoming Events</h2>
    
    <!-- Event Filters -->
    <div class="event-filters">
      <div class="filter-group">
        <label for="date-from">From:</label>
        <input type="date" id="date-from" onchange="filterEvents()">
      </div>
      <div class="filter-group">
        <label for="date-to">To:</label>
        <input type="date" id="date-to" onchange="filterEvents()">
      </div>
    </div>

    <!-- Kalender abonnieren CTA -->
    <div class="events-cta">
      <a 
        href="<?php echo esc_url( add_query_arg( 'feed', 'events_ical', home_url() ) ); ?>" 
        target="_blank" 
        rel="noopener" 
        class="subscribe-btn"
      >
        <span>📅</span>
        <span>Subscribe to Calendar</span>
      </a>
    </div>

    <div class="events-grid">
      <?php
      $current_date = current_time('Y-m-d H:i:s');
      
      $args = array(
        'post_type'      => 'event',
        'posts_per_page' => 9, // Show only 9 events initially
        'meta_query'     => array(
          'relation' => 'AND',
          array(
            'key'     => 'event_start',
            'compare' => 'EXISTS'
          ),
          array(
            'key'     => 'event_start',
            'value'   => $current_date,
            'compare' => '>=',
            'type'    => 'DATETIME'
          )
        ),
        'orderby'        => 'meta_value',
        'meta_key'       => 'event_start',
        'order'          => 'ASC',
        'post_status'    => 'publish'
      );
      $events = new WP_Query($args);
      $total_events = $events->found_posts;
      
      if ($events->have_posts()) :
        while ($events->have_posts()) : $events->the_post();
          $event_start = get_field('event_start');
          $event_end = get_field('event_end');
          $location = get_field('event_location');
          
          if (!$event_start) {
            continue;
          }
          
          // Convert UK date format to timestamp
          $date = DateTime::createFromFormat('d/m/Y g:i a', $event_start);
          if (!$date) {
            continue;
          }
          
          $event_year = $date->format('Y');
          $event_month = $date->format('m');
      ?>
        <div class="event-post" 
             data-year="<?php echo esc_attr($event_year); ?>" 
             data-month="<?php echo esc_attr($event_month); ?>"
             data-date="<?php echo esc_attr($date->format('Y-m-d')); ?>">
          <a href="<?php the_permalink(); ?>">
            <div class="event-image">
              <?php if (has_post_thumbnail()) {
                the_post_thumbnail('medium');
              } else { ?>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/def.jpg" alt="">
              <?php } ?>
            </div>
            <div class="event-content">
              <h3><?php the_title(); ?></h3>
              <?php if ($event_start): ?>
                <div class="textline">🗓 <?php echo $date->format('j. F Y, H:i'); ?></div>
              <?php endif; ?>
              <?php if ($event_end && $event_end !== $event_start): 
                $end_date = DateTime::createFromFormat('d/m/Y g:i a', $event_end);
                if ($end_date): ?>
                  <div class="textline">bis <?php echo $end_date->format('j. F Y, H:i'); ?></div>
                <?php endif;
              endif; ?>
              <?php if ($location && mb_strlen($location) <= 30): ?>
                <div class="textline">📍 <?php echo esc_html($location); ?></div>
              <?php endif; ?>
              <div class="event-excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
              </div>
            </div>
          </a>
        </div>
      <?php
        endwhile;
        wp_reset_postdata();
        
        // Show "View All" button if there are more than 9 events
        if ($total_events > 9) : ?>
          <div class="view-all-events">
            <button id="load-more-events" class="btn btn-primary">Show All Upcoming Events</button>
          </div>
        <?php endif;
      else:
        echo '<p>No upcoming events found.</p>';
      endif;
      ?>
    </div>
  </div>
</div>

<?php get_template_part('components/join', 'section'); ?>

<!-- Past Events Section -->
<div class="more-news">
  <div class="wrap">
    <h2>Past Events</h2>
    <div class="news-grid">
      <?php
      $past_events_args = array(
        'post_type'      => 'event',
        'posts_per_page' => 3,
        'meta_query'     => array(
          'relation' => 'AND',
          array(
            'key'     => 'event_start',
            'compare' => 'EXISTS'
          ),
          array(
            'key'     => 'event_start',
            'value'   => $current_date,
            'compare' => '<',
            'type'    => 'DATETIME'
          )
        ),
        'orderby'        => 'meta_value',
        'meta_key'       => 'event_start',
        'order'          => 'DESC',
        'post_status'    => 'publish'
      );
      $past_events = new WP_Query($past_events_args);
      if ($past_events->have_posts()) :
        while ($past_events->have_posts()) : $past_events->the_post();
          $event_start = get_field('event_start');
          $location = get_field('event_location');
          
          if (!$event_start) {
            continue;
          }
          
          $date = DateTime::createFromFormat('d/m/Y g:i a', $event_start);
          if (!$date) {
            continue;
          }
      ?>
        <div class="news-item">
          <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) {
              the_post_thumbnail('medium');
            } ?>
            <h3><?php the_title(); ?></h3>
            <?php if ($event_start): ?>
              <div class="textline">🗓 <?php echo $date->format('j. F Y, H:i'); ?></div>
            <?php endif; ?>
            <?php if ($location && mb_strlen($location) <= 30): ?>
              <div class="textline">📍 <?php echo esc_html($location); ?></div>
            <?php endif; ?>
            <div class="news-excerpt">
              <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
            </div>
          </a>
        </div>
      <?php
        endwhile;
        wp_reset_postdata();
      endif;
      ?>
    </div>
  </div>
</div>

<script>
function filterEvents() {
  const dateFrom = document.getElementById('date-from').value;
  const dateTo = document.getElementById('date-to').value;
  const events = document.querySelectorAll('.event-post');
  let visibleCount = 0;
  
  // Convert NodeList to Array for sorting
  const eventsArray = Array.from(events);
  
  // Sort events by date (next upcoming first)
  eventsArray.sort((a, b) => {
    const dateA = new Date(a.dataset.date);
    const dateB = new Date(b.dataset.date);
    return dateA - dateB;
  });
  
  // Reorder events in DOM
  const eventsGrid = document.querySelector('.events-grid');
  eventsArray.forEach(event => {
    eventsGrid.appendChild(event);
  });
  
  // If no date filters, show all events
  if (!dateFrom && !dateTo) {
    eventsArray.forEach(event => {
      event.style.display = 'block';
      visibleCount++;
    });
  } else {
    const fromDate = dateFrom ? new Date(dateFrom) : new Date(0);
    const toDate = dateTo ? new Date(dateTo) : new Date(8640000000000000);
    
    eventsArray.forEach(event => {
      const eventDate = new Date(event.dataset.date);
      if (eventDate >= fromDate && eventDate <= toDate) {
        event.style.display = 'block';
        visibleCount++;
      } else {
        event.style.display = 'none';
      }
    });
  }
  
  // Show/hide "no events" message
  const noEventsMsg = document.querySelector('.no-events-message');
  if (visibleCount === 0) {
    if (!noEventsMsg) {
      const msg = document.createElement('p');
      msg.className = 'no-events-message';
      msg.textContent = 'No events found for the selected date range.';
      document.querySelector('.events-grid').appendChild(msg);
    }
  } else if (noEventsMsg) {
    noEventsMsg.remove();
  }
}

// Load more events
document.addEventListener('DOMContentLoaded', function() {
  const loadMoreBtn = document.getElementById('load-more-events');
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function() {
      const currentEvents = document.querySelectorAll('.event-post').length;
      
      // AJAX request to load more events
      fetch(ajaxurl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
          action: 'load_more_events',
          offset: currentEvents,
          nonce: '<?php echo wp_create_nonce("load_more_events"); ?>'
        })
      })
      .then(response => response.text())
      .then(html => {
        const eventsGrid = document.querySelector('.events-grid');
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        
        // Insert new events before the "View All" button
        const viewAllBtn = document.querySelector('.view-all-events');
        if (viewAllBtn) {
          eventsGrid.insertBefore(tempDiv, viewAllBtn);
        } else {
          eventsGrid.appendChild(tempDiv);
        }
        
        // Hide the button if we've loaded all events
        if (html.trim() === '') {
          loadMoreBtn.style.display = 'none';
        }
      });
    });
  }
  
  // Initial sort
  filterEvents();
});
</script>

<?php get_footer(); ?>
