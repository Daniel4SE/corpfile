<!-- Help Article -->
<div class="page-title">
    <div class="title_left">
        <h3>Help Article</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('help') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Help Center</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-9">
        <div class="x_panel">
            <div class="x_title">
                <h2><?= htmlspecialchars($article->title ?? 'Article') ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if (!empty($article)): ?>
                    <div class="article-meta text-muted" style="margin-bottom:15px;">
                        <i class="fa fa-calendar"></i> <?= !empty($article->created_at) ? date('d M Y', strtotime($article->created_at)) : '' ?>
                        <?php if (!empty($article->category)): ?>
                            &nbsp; | &nbsp; <i class="fa fa-folder"></i> <?= htmlspecialchars($article->category) ?>
                        <?php endif; ?>
                    </div>
                    <div class="article-content">
                        <?= $article->content ?? '' ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> This help article is not yet available. Please check back later or contact support.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i> Related Articles</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <ul class="list-unstyled" style="line-height:2.2;">
                    <li><a href="<?= base_url('help') ?>"><i class="fa fa-home"></i> Help Center Home</a></li>
                    <li><a href="<?= base_url('support') ?>"><i class="fa fa-life-ring"></i> Contact Support</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
