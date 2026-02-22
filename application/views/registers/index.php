<!-- Registers Index -->
<div class="page-title">
    <div class="title_left">
        <h3><?= $page_title ?? 'Registers' ?></h3>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <?php
    $register_types = [
        ['icon' => 'fa-users', 'title' => 'Register of Members', 'route' => 'registers/register_of_members', 'color' => '#206570'],
        ['icon' => 'fa-user-secret', 'title' => 'Register of Directors', 'route' => 'registers/register_of_directors', 'color' => '#337ab7'],
        ['icon' => 'fa-user', 'title' => 'Register of Secretaries', 'route' => 'registers/register_of_secretaries', 'color' => '#26B99A'],
        ['icon' => 'fa-link', 'title' => 'Register of Charges', 'route' => 'registers/register_of_charges', 'color' => '#5cb85c'],
        ['icon' => 'fa-file-text', 'title' => 'Register of Debenture Holders', 'route' => 'registers/register_of_debenture_holders', 'color' => '#f27b53'],
        ['icon' => 'fa-shield', 'title' => 'Register of Auditors', 'route' => 'registers/register_of_auditors', 'color' => '#E74C3C'],
        ['icon' => 'fa-user-plus', 'title' => 'Register of Nominee Directors', 'route' => 'registers/register_of_nominee_directors', 'color' => '#f0ad4e'],
        ['icon' => 'fa-star', 'title' => 'Register of Substantial Shareholders', 'route' => 'registers/register_of_substantial_shareholders', 'color' => '#9B59B6'],
        ['icon' => 'fa-pie-chart', 'title' => 'Register of Directors Shareholdings', 'route' => 'registers/register_of_directors_shareholdings', 'color' => '#3498DB'],
        ['icon' => 'fa-exchange', 'title' => 'Register of Transfers', 'route' => 'registers/register_of_transfers', 'color' => '#1ABC9C'],
        ['icon' => 'fa-plus-circle', 'title' => 'Register of Allotments', 'route' => 'registers/register_of_allotments', 'color' => '#2C3E50'],
        ['icon' => 'fa-stamp', 'title' => 'Register of Seals', 'route' => 'registers/register_of_seals', 'color' => '#8E44AD'],
        ['icon' => 'fa-pencil-square-o', 'title' => 'Register of Applicants', 'route' => 'registers/register_of_applicants', 'color' => '#D35400'],
        ['icon' => 'fa-cogs', 'title' => 'Register of Controllers', 'route' => 'registers/register_of_controllers', 'color' => '#27AE60'],
        ['icon' => 'fa-eye', 'title' => 'Register of Beneficial Owners', 'route' => 'registers/register_of_beneficial_owners', 'color' => '#C0392B'],
        ['icon' => 'fa-user-circle', 'title' => 'Register of Nominee Shareholders', 'route' => 'registers/register_of_nominee_shareholders', 'color' => '#7F8C8D'],
        ['icon' => 'fa-book', 'title' => 'Minute Book - Directors', 'route' => 'registers/minute_book_directors', 'color' => '#2980B9'],
        ['icon' => 'fa-book', 'title' => 'Minute Book - Members', 'route' => 'registers/minute_book_members', 'color' => '#16A085'],
        ['icon' => 'fa-certificate', 'title' => 'Share Certificate', 'route' => 'registers/share_certificate', 'color' => '#F39C12'],
        ['icon' => 'fa-file', 'title' => 'Annual Return', 'route' => 'registers/annual_return', 'color' => '#E67E22'],
        ['icon' => 'fa-bank', 'title' => 'Register of Depository Agents', 'route' => 'registers/register_of_depository_agents', 'color' => '#E74C3C'],
        ['icon' => 'fa-briefcase', 'title' => 'Register of Managers', 'route' => 'registers/register_of_managers', 'color' => '#3498DB'],
        ['icon' => 'fa-handshake-o', 'title' => 'Register of Partners', 'route' => 'registers/register_of_partners', 'color' => '#E91E63'],
    ];
    foreach ($register_types as $reg):
    ?>
    <div class="col-md-3 col-sm-4 col-xs-6" style="margin-bottom:15px;">
        <a href="<?= base_url($reg['route']) ?>" style="text-decoration:none;">
            <div class="x_panel" style="cursor:pointer;min-height:140px;transition:all 0.3s;">
                <div class="x_content" style="text-align:center;padding:20px 10px;">
                    <div style="width:50px;height:50px;border-radius:50%;background:<?= $reg['color'] ?>;display:inline-flex;align-items:center;justify-content:center;margin-bottom:10px;">
                        <i class="fa <?= $reg['icon'] ?>" style="color:#fff;font-size:18px;"></i>
                    </div>
                    <h4 style="color:<?= $reg['color'] ?>;font-size:12px;font-weight:bold;margin:0;"><?= $reg['title'] ?></h4>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<script>
$(document).ready(function() {
    $('.x_panel').hover(
        function() { $(this).css({'box-shadow': '0 4px 15px rgba(0,0,0,0.15)', 'transform': 'translateY(-2px)'}); },
        function() { $(this).css({'box-shadow': '', 'transform': ''}); }
    );
});
</script>
