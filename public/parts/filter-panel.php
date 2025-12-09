 <div class="uk-card uk-card-default uk-card-body filter-panel">
     <h3 class="uk-card-title filter-panel-title">
         <span uk-icon="icon: filter; ratio: 1.2"></span> Filters & Sorting
     </h3>

     <div class="filter-buttons">
         <!-- Sort Button -->
         <?php if ($sortBy === 'price'): ?>
         <a href="?sort=price&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?><?php echo $filterAbove100 ? '&filter=above100' : ''; ?>"
             class="uk-button uk-button-primary uk-width-1-1 filter-button filter-button-active">
             <span uk-icon="<?php echo $order === 'ASC' ? 'arrow-up' : 'arrow-down'; ?>"></span>
             <span>Sort by Price (<?php echo $order === 'ASC' ? 'Low to High' : 'High to Low'; ?>)</span>
         </a>
         <?php else: ?>
         <a href="?sort=price&order=ASC<?php echo $filterAbove100 ? '&filter=above100' : ''; ?>"
             class="uk-button uk-button-default uk-width-1-1 filter-button">
             <span uk-icon="icon: sort; ratio: 1"></span>
             <span>Sort by Price</span>
         </a>
         <?php endif; ?>

         <!-- Filter Button -->
         <?php if ($filterAbove100): ?>
         <a href="?<?php echo $sortBy === 'price' ? 'sort=price&order=' . $order : ''; ?>"
             class="uk-button uk-button-danger uk-width-1-1 filter-button filter-button-active uk-margin-small-top">
             <span uk-icon="icon: close; ratio: 1"></span>
             <span>Clear Filter</span>
         </a>
         <?php else: ?>
         <a href="?filter=above100<?php echo $sortBy === 'price' ? '&sort=price&order=' . $order : ''; ?>"
             class="uk-button uk-button-secondary uk-width-1-1 filter-button uk-margin-small-top">
             <span uk-icon="icon: tag; ratio: 1"></span>
             <span>Above $100</span>
         </a>
         <?php endif; ?>
     </div>

     <!-- Active Filters Display -->
     <div class="active-filters uk-margin-top">
         <?php if ($filterAbove100): ?>
         <span class="uk-badge active-filter-badge">
             <span uk-icon="icon: check; ratio: 0.8"></span>
             Filter: Above $100
         </span>
         <?php endif; ?>
         <?php if ($sortBy === 'price'): ?>
         <span class="uk-badge active-filter-badge">
             <span uk-icon="icon: check; ratio: 0.8"></span>
             Sorted by Price (<?php echo $order === 'ASC' ? 'Ascending' : 'Descending'; ?>)
         </span>
         <?php endif; ?>
     </div>
 </div>