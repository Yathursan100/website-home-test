 <div class="uk-grid-small uk-grid-match uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-3@l"
                    uk-grid>
                    <?php foreach ($products as $product): ?>
                    <div>
                        <div class="uk-card uk-card-default uk-card-hover product-card">
                            <!-- Product Image -->
                            <div class="uk-card-media-top">
                                <img src="<?php echo sanitize($product['image']); ?>"
                                    alt="<?php echo sanitize($product['title']); ?>" class="uk-responsive-width product-image">
                            </div>
                            <div class="uk-card-body">
                                <!-- Category Badge -->
                                <div class="uk-margin-small-bottom">
                                    <span
                                        class="uk-badge category-badge"><?php echo sanitize($product['category']); ?></span>
                                </div>
                                <!-- Product Title -->
                                <h3 class="uk-card-title uk-margin-remove-top product-title">
                                    <?php echo sanitize($product['title']); ?>
                                </h3>

                                <!-- Rating -->
                                <div class="uk-margin-small">
                                    <span class="rating">
                                        <?php
                                        $rating = (float) $product['rating_rate'];
                                        $fullStars = floor($rating);
                                        $hasHalfStar = ($rating - $fullStars) >= 0.5;

                                        for ($i = 0; $i < $fullStars; $i++) {
                                            echo '★ ';
                                        }
                                        if ($hasHalfStar) {
                                            echo '⯨';
                                        }
                                        // for ($i = $fullStars + ($hasHalfStar ? 1 : 0); $i < 5; $i++) {
                                        //     echo '☆';
                                        // }
                                        ?>
                                        <span class="rating-text">(<?php echo number_format($rating, 1); ?>)</span>
                                    </span>
                                    <span class="uk-text-muted uk-text-small"><?php echo $product['rating_count']; ?>
                                        reviews</span>
                                </div>
                                <!-- Price -->
                                <div class="uk-margin-small">
                                    <span class="product-price"><?php echo formatPrice($product['price']); ?></span>
                                </div>
                                <p class="uk-text-small uk-text-muted product-description">
                                    <?php echo sanitize(truncateText($product['description'], 100)); ?>
                                </p>
                                <div class="uk-margin-top">
                                    <button class="uk-button uk-button-primary uk-width-1-1 buy-button">
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>