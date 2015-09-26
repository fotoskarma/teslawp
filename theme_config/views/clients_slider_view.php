<div class="clients" style="<?php echo $shortcode['style']; ?>">
    <div class="titleContainer font1">
        <div class="title">
            <?php echo $shortcode['title']; ?>
        </div>
        <div class="clientsNav">
            <div class="clientsNavPrev"></div>
            <div class="clientsNavNext"></div>
        </div>
    </div>
    <ul>
        <?php foreach($slides as $slide): ?>
        <li>
            <?php if(empty($slide['options']['url'])): ?>
            <img src="<?php echo $slide['options']['image']; ?>" alt="" />
            <?php else: ?>
            <a href="<?php echo $slide['options']['url']; ?>"><img src="<?php echo $slide['options']['image']; ?>" alt="" /></a>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>