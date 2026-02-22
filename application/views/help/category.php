<!-- Help Category -->
<div class="page-title">
    <div class="title_left">
        <h3>Help: <?= htmlspecialchars($category->name ?? 'Category') ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('help') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Help Center</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-folder-open"></i> <?= htmlspecialchars($category->name ?? 'Category Articles') ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if (!empty($articles)): ?>
                    <div class="list-group">
                        <?php foreach ($articles as $article): ?>
                            <a href="<?= base_url('help/article/' . $article->id) ?>" class="list-group-item">
                                <h4 class="list-group-item-heading"><i class="fa fa-file-text-o"></i> <?= htmlspecialchars($article->title ?? '') ?></h4>
                                <p class="list-group-item-text text-muted"><?= htmlspecialchars($article->excerpt ?? '') ?></p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> No articles found in this category. Please check back later.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
