<?php 
// File: views/client/product_detail.php
include 'views/layouts/header.php'; 
?>

<!-- ============================================
     BREADCRUMB SECTION
     ============================================ -->
<section class="breadcrumb-section py-3 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="?page=home">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="?page=shop">Shop</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= htmlspecialchars($product['name']) ?>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- ============================================
     PRODUCT DETAIL SECTION
     ============================================ -->
<section class="product-detail-section py-5">
    <div class="container">
        <div class="row">
            
            <!-- ============ LEFT: PRODUCT IMAGES ============ -->
            <div class="col-lg-6 mb-4">
                <div class="product-images-wrapper">
                    <!-- Main Image Display -->
                    <div class="main-image-container mb-3">
                        <img src="<?= htmlspecialchars($productImages[0]['image_url']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="img-fluid rounded shadow-sm"
                             id="mainProductImage"
                             class="main-product-img">
                    </div>
                    
                    <!-- Thumbnail Images Gallery -->
                    <div class="thumbnail-gallery d-flex gap-2 flex-wrap">
                        <?php foreach ($productImages as $index => $image): ?>
                            <div class="thumbnail-item">
                                <img src="<?= htmlspecialchars($image['image_url']) ?>" 
                                     alt="Product view <?= $index + 1 ?>" 
                                     class="img-thumbnail <?= $index === 0 ? 'active' : '' ?>"
                                     style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                     onclick="changeMainImage('<?= htmlspecialchars($image['image_url']) ?>', this)"
                                     data-index="<?= $index ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- ============ RIGHT: PRODUCT INFO ============ -->
            <div class="col-lg-6">
                <div class="product-info-wrapper">
                    
                    <!-- Product Title -->
                    <h1 class="product-title mb-3 fw-bold">
                        <?= htmlspecialchars($product['name']) ?>
                    </h1>
                    
                    <!-- Brand Badge -->
                    <div class="product-brand mb-3">
                        <span class="badge bg-secondary">
                            <i class="bi bi-tag-fill"></i> <?= htmlspecialchars($product['brand']) ?>
                        </span>
                    </div>
                    
                    <!-- Price Display -->
                    <div class="product-pricing mb-3">
                        <h2 class="price-display text-primary fw-bold mb-0" id="displayPrice">
                            <?= number_format($displayPrice, 0, ',', '.') ?>đ
                        </h2>
                        <small class="text-muted">Base price: <?= number_format($product['price'], 0, ',', '.') ?>đ</small>
                    </div>
                    
                    <!-- Rating & Reviews -->
                    <div class="product-rating mb-4 d-flex align-items-center gap-3 border-top border-bottom py-3">
                        <div class="stars-display text-warning fs-5">
                            <?php
                            $rating = $product['average_rating'] ?? 0;
                            $fullStars = floor($rating);
                            $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - $fullStars - $halfStar;
                            
                            for ($i = 0; $i < $fullStars; $i++) {
                                echo '<i class="bi bi-star-fill"></i>';
                            }
                            if ($halfStar) {
                                echo '<i class="bi bi-star-half"></i>';
                            }
                            for ($i = 0; $i < $emptyStars; $i++) {
                                echo '<i class="bi bi-star"></i>';
                            }
                            ?>
                        </div>
                        <div class="rating-text">
                            <strong><?= number_format($rating, 1) ?></strong>
                            <span class="text-muted">(<?= $product['review_count'] ?> reviews)</span>
                        </div>
                    </div>
                    
                    <!-- Short Description -->
                    <div class="product-description mb-4">
                        <p class="text-muted">
                            <?= htmlspecialchars($product['description']) ?>
                        </p>
                    </div>
                    
                    <!-- ============ STORAGE VARIANTS ============ -->
                    <?php if (!empty($variants['storage'])): ?>
                        <div class="variant-section mb-4">
                            <h6 class="variant-label fw-bold mb-2">
                                <i class="bi bi-hdd-fill text-primary"></i> Storage:
                            </h6>
                            <div class="btn-group flex-wrap" role="group" id="storageVariants">
                                <?php foreach ($variants['storage'] as $storage): ?>
                                    <input type="radio" 
                                           class="btn-check variant-radio" 
                                           name="storage" 
                                           id="storage<?= $storage['id'] ?>" 
                                           value="<?= $storage['id'] ?>"
                                           data-price-modifier="<?= $storage['price_modifier'] ?>"
                                           data-stock="<?= $storage['stock'] ?>"
                                           autocomplete="off"
                                           <?= $storage['is_default'] ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-primary" for="storage<?= $storage['id'] ?>">
                                        <?= htmlspecialchars($storage['variant_name']) ?>
                                        <?php if ($storage['price_modifier'] > 0): ?>
                                            <small class="d-block text-success">
                                                +<?= number_format($storage['price_modifier'], 0, ',', '.') ?>đ
                                            </small>
                                        <?php endif; ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- ============ COLOR VARIANTS ============ -->
                    <?php if (!empty($variants['color'])): ?>
                        <div class="variant-section mb-4">
                            <h6 class="variant-label fw-bold mb-2">
                                <i class="bi bi-palette-fill text-primary"></i> Color:
                                <span id="selectedColorName" class="text-muted fw-normal">
                                    <?= $variants['color'][0]['variant_name'] ?>
                                </span>
                            </h6>
                            <div class="color-variants-wrapper d-flex gap-2">
                                <?php foreach ($variants['color'] as $index => $color): ?>
                                    <div class="color-option-wrapper">
                                        <input type="radio" 
                                               class="btn-check color-radio" 
                                               name="color" 
                                               id="color<?= $color['id'] ?>" 
                                               value="<?= $color['id'] ?>"
                                               data-color-name="<?= htmlspecialchars($color['variant_name']) ?>"
                                               data-stock="<?= $color['stock'] ?>"
                                               autocomplete="off"
                                               <?= $index === 0 ? 'checked' : '' ?>>
                                        <label class="color-swatch" 
                                               for="color<?= $color['id'] ?>"
                                               style="background-color: <?= htmlspecialchars($color['variant_value']) ?>;"
                                               title="<?= htmlspecialchars($color['variant_name']) ?>">
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- ============ RAM VARIANTS (if exists) ============ -->
                    <?php if (!empty($variants['ram'])): ?>
                        <div class="variant-section mb-4">
                            <h6 class="variant-label fw-bold mb-2">
                                <i class="bi bi-memory text-primary"></i> RAM:
                            </h6>
                            <div class="btn-group flex-wrap" role="group">
                                <?php foreach ($variants['ram'] as $ram): ?>
                                    <input type="radio" 
                                           class="btn-check variant-radio" 
                                           name="ram" 
                                           id="ram<?= $ram['id'] ?>" 
                                           value="<?= $ram['id'] ?>"
                                           data-stock="<?= $ram['stock'] ?>"
                                           autocomplete="off"
                                           <?= $ram['is_default'] ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-primary" for="ram<?= $ram['id'] ?>">
                                        <?= htmlspecialchars($ram['variant_name']) ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- ============ QUANTITY SELECTOR ============ -->
                    <div class="quantity-section mb-4">
                        <h6 class="fw-bold mb-2">Quantity:</h6>
                        <div class="d-flex align-items-center gap-3">
                            <div class="input-group" style="width: 150px;">
                                <button class="btn btn-outline-secondary" type="button" id="decreaseQty">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" 
                                       class="form-control text-center fw-bold" 
                                       value="1" 
                                       min="1" 
                                       max="<?= $product['stock'] ?>" 
                                       id="productQuantity" 
                                       readonly>
                                <button class="btn btn-outline-secondary" type="button" id="increaseQty">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-box-seam"></i> 
                                Available: <strong id="stockDisplay"><?= $product['stock'] ?></strong> items
                            </small>
                        </div>
                    </div>
                    
                    <!-- ============ ACTION BUTTONS ============ -->
                    <div class="action-buttons mb-4 d-flex gap-2">
                        <button class="btn btn-primary btn-lg flex-grow-1 add-to-cart-btn" 
                                data-product-id="<?= $product['id'] ?>">
                            <i class="bi bi-cart-plus-fill"></i> Add To Cart
                        </button>
                        <button class="btn btn-outline-secondary btn-lg" 
                                title="Add to Wishlist">
                            <i class="bi bi-heart"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-lg" 
                                title="Compare">
                            <i class="bi bi-arrow-left-right"></i>
                        </button>
                    </div>
                    
                    <!-- ============ PRODUCT META INFO ============ -->
                    <div class="product-meta border-top pt-3">
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 30%;">
                                        <strong>SKU:</strong>
                                    </td>
                                    <td>PROD<?= str_pad($product['id'], 5, '0', STR_PAD_LEFT) ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <strong>Category:</strong>
                                    </td>
                                    <td>
                                        <a href="?page=shop&category=<?= urlencode($product['category']) ?>" 
                                           class="text-decoration-none">
                                            <?= htmlspecialchars($product['category']) ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <strong>Brand:</strong>
                                    </td>
                                    <td>
                                        <a href="?page=shop&brand[]=<?= urlencode($product['brand']) ?>" 
                                           class="text-decoration-none">
                                            <?= htmlspecialchars($product['brand']) ?>
                                        </a>
                                    </td>
                                </tr>
                                <?php if ($product['storage']): ?>
                                <tr>
                                    <td class="text-muted">
                                        <strong>Storage:</strong>
                                    </td>
                                    <td><?= htmlspecialchars($product['storage']) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($product['ram']): ?>
                                <tr>
                                    <td class="text-muted">
                                        <strong>RAM:</strong>
                                    </td>
                                    <td><?= htmlspecialchars($product['ram']) ?></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- ============================================
     TABS: DESCRIPTION, ADDITIONAL INFO, REVIEWS
     ============================================ -->
<section class="product-tabs-section py-5 bg-light">
    <div class="container">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs nav-fill" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" 
                        id="description-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#description" 
                        type="button">
                    <i class="bi bi-file-text"></i> Description
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="additional-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#additional" 
                        type="button">
                    <i class="bi bi-info-circle"></i> Additional Information
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" 
                        id="reviews-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#reviews" 
                        type="button">
                    <i class="bi bi-chat-left-text"></i> Reviews (<?= $product['review_count'] ?>)
                </button>
            </li>
        </ul>
        
        <!-- Tab Content -->
        <div class="tab-content bg-white p-4 rounded-bottom shadow-sm" id="productTabsContent">
            
            <!-- ========== DESCRIPTION TAB ========== -->
            <div class="tab-pane fade show active" id="description" role="tabpanel">
                <h5 class="mb-3 fw-bold">Product Description</h5>
                <p class="text-muted"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                
                <?php if ($product['category'] == 'Phones'): ?>
                    <h6 class="mt-4 mb-3 fw-bold">Key Features:</h6>
                    <ul class="feature-list">
                        <li><strong>Brand:</strong> <?= htmlspecialchars($product['brand']) ?></li>
                        <?php if ($product['storage']): ?>
                            <li><strong>Storage:</strong> <?= htmlspecialchars($product['storage']) ?></li>
                        <?php endif; ?>
                        <?php if ($product['ram']): ?>
                            <li><strong>RAM:</strong> <?= htmlspecialchars($product['ram']) ?></li>
                        <?php endif; ?>
                        <li><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></li>
                        <li><strong>Stock:</strong> <?= $product['stock'] ?> units available</li>
                    </ul>
                <?php endif; ?>
            </div>
            
            <!-- ========== ADDITIONAL INFORMATION TAB ========== -->
            <div class="tab-pane fade" id="additional" role="tabpanel">
                <h5 class="mb-3 fw-bold">Additional Information</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="30%" class="bg-light">Brand</th>
                            <td><?= htmlspecialchars($product['brand']) ?></td>
                        </tr>
                        <?php if ($product['storage']): ?>
                        <tr>
                            <th class="bg-light">Storage Options</th>
                            <td>
                                <?php 
                                $storageOptions = array_column($variants['storage'], 'variant_name');
                                echo implode(', ', $storageOptions);
                                ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($variants['color'])): ?>
                        <tr>
                            <th class="bg-light">Available Colors</th>
                            <td>
                                <?php 
                                $colorOptions = array_column($variants['color'], 'variant_name');
                                echo implode(', ', $colorOptions);
                                ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($product['ram']): ?>
                        <tr>
                            <th class="bg-light">RAM</th>
                            <td><?= htmlspecialchars($product['ram']) ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th class="bg-light">Category</th>
                            <td><?= htmlspecialchars($product['category']) ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Availability</th>
                            <td>
                                <?php if ($product['stock'] > 0): ?>
                                    <span class="badge bg-success">In Stock (<?= $product['stock'] ?> items)</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Out of Stock</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Average Rating</th>
                            <td>
                                <strong><?= number_format($product['average_rating'], 1) ?>/5.0</strong>
                                (based on <?= $product['review_count'] ?> reviews)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- ========== REVIEWS TAB (PLACEHOLDER) ========== -->
            <div class="tab-pane fade" id="reviews" role="tabpanel">
                <h5 class="mb-4 fw-bold">Customer Reviews</h5>
                
                <!-- Placeholder Message -->
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle fs-3"></i>
                    <p class="mb-0 mt-2">
                        <strong>Reviews feature coming soon!</strong><br>
                        Login feature is being developed by team member.
                    </p>
                </div>
                
                <!-- Average Rating Display -->
                <div class="text-center py-4 border rounded bg-light">
                    <h2 class="mb-2"><?= number_format($product['average_rating'], 1) ?> / 5.0</h2>
                    <div class="stars-display text-warning fs-4 mb-2">
                        <?php
                        $rating = $product['average_rating'];
                        $fullStars = floor($rating);
                        $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                        $emptyStars = 5 - $fullStars - $halfStar;
                        
                        for ($i = 0; $i < $fullStars; $i++) echo '<i class="bi bi-star-fill"></i>';
                        if ($halfStar) echo '<i class="bi bi-star-half"></i>';
                        for ($i = 0; $i < $emptyStars; $i++) echo '<i class="bi bi-star"></i>';
                        ?>
                    </div>
                    <p class="text-muted mb-0">Based on <?= $product['review_count'] ?> reviews</p>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- ============================================
     RELATED PRODUCTS
     ============================================ -->
<?php if (!empty($relatedProducts)): ?>
<section class="related-products-section py-5">
    <div class="container">
        <h3 class="text-center mb-4 fw-bold">Related Products</h3>
        <div class="row">
            <?php foreach ($relatedProducts as $relProd): ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <a href="?page=product&id=<?= $relProd['id'] ?>">
                            <img src="<?= $relProd['primary_image'] ?? $relProd['image'] ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($relProd['name']) ?>"
                                 style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="?page=product&id=<?= $relProd['id'] ?>" 
                                   class="text-decoration-none text-dark">
                                    <?= htmlspecialchars($relProd['name']) ?>
                                </a>
                            </h6>
                            <p class="card-text text-primary fw-bold mb-2">
                                <?= number_format($relProd['price'], 0, ',', '.') ?>đ
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <?php
                                    $relRating = $relProd['average_rating'] ?? 0;
                                    echo str_repeat('★', floor($relRating));
                                    echo str_repeat('☆', 5 - floor($relRating));
                                    ?>
                                </small>
                                <a href="?page=product&id=<?= $relProd['id'] ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================
     JAVASCRIPT FOR PRODUCT PAGE
     ============================================ -->
<script>
// Base price từ PHP
const basePrice = <?= $product['price'] ?>;
let currentPriceModifier = 0;

// ========== CHANGE MAIN IMAGE ON THUMBNAIL CLICK ==========
function changeMainImage(imageUrl, thumbnailElement) {
    // Update main image
    document.getElementById('mainProductImage').src = imageUrl;
    
    // Remove active class from all thumbnails
    document.querySelectorAll('.thumbnail-item img').forEach(img => {
        img.classList.remove('active');
    });
    
    // Add active class to clicked thumbnail
    thumbnailElement.classList.add('active');
}

// ========== QUANTITY INCREASE/DECREASE ==========
document.getElementById('increaseQty').addEventListener('click', function() {
    const input = document.getElementById('productQuantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    
    if (current < max) {
        input.value = current + 1;
    }
});

document.getElementById('decreaseQty').addEventListener('click', function() {
    const input = document.getElementById('productQuantity');
    const current = parseInt(input.value);
    
    if (current > 1) {
        input.value = current - 1;
    }
});

// ========== UPDATE PRICE WHEN STORAGE VARIANT CHANGES ==========
document.querySelectorAll('.variant-radio[name="storage"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.checked) {
            const priceModifier = parseFloat(this.dataset.priceModifier) || 0;
            currentPriceModifier = priceModifier;
            updateDisplayPrice();
            
            // Update stock display
            const stock = this.dataset.stock;
            document.getElementById('stockDisplay').textContent = stock;
            document.getElementById('productQuantity').max = stock;
        }
    });
});

// ========== UPDATE COLOR NAME WHEN COLOR CHANGES ==========
document.querySelectorAll('.color-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.checked) {
            const colorName = this.dataset.colorName;
            document.getElementById('selectedColorName').textContent = colorName;
        }
    });
});

// ========== UPDATE PRICE DISPLAY ==========
function updateDisplayPrice() {
    const finalPrice = basePrice + currentPriceModifier;
    document.getElementById('displayPrice').textContent = 
        finalPrice.toLocaleString('vi-VN') + 'đ';
}

// ========== COLOR SWATCH ACTIVE STATE ==========
document.querySelectorAll('.color-swatch').forEach(swatch => {
    swatch.addEventListener('click', function() {
        document.querySelectorAll('.color-swatch').forEach(s => {
            s.classList.remove('active-color');
        });
        this.classList.add('active-color');
    });
});

// ========== ADD TO CART WITH VARIANTS & QUANTITY ==========
document.querySelector('.add-to-cart-btn').addEventListener('click', function() {
    const productId = this.getAttribute('data-product-id');
    const quantity = document.getElementById('productQuantity').value;
    
    // Get selected storage (if exists)
    const selectedStorage = document.querySelector('.variant-radio[name="storage"]:checked');
    const storageId = selectedStorage ? selectedStorage.value : null;
    
    // Get selected color (if exists)
    const selectedColor = document.querySelector('.color-radio:checked');
    const colorId = selectedColor ? selectedColor.value : null;
    
    // Get selected RAM (if exists)
    const selectedRam = document.querySelector('.variant-radio[name="ram"]:checked');
    const ramId = selectedRam ? selectedRam.value : null;
    
    // Call cart.js addToCart method
    if (typeof cart !== 'undefined') {
        cart.addToCart(productId, quantity, {
            storage_id: storageId,
            color_id: colorId,
            ram_id: ramId
        });
    } else {
        console.error('Cart object not found. Make sure cart.js is loaded.');
    }
});
</script>



<?php include 'views/layouts/footer.php'; ?>


<div data-base-price="<?= $product['price'] ?>" style="display:none;"></div>
