<!-- CSS Reports -->
<div class="page-title">
    <div class="title_left">
        <h3>CSS Reports</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('reports') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Reports</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <?php
    $css_report_types = [
        ['icon' => 'fa-building',        'title' => 'Company List Report',      'desc' => 'Complete listing of all companies with key details',             'color' => '#206570', 'type' => 'official_contact_address'],
        ['icon' => 'fa-user-secret',     'title' => 'Director Report',          'desc' => 'All directors with appointments and cessations',                 'color' => '#337ab7', 'type' => 'comp_director_report'],
        ['icon' => 'fa-users',           'title' => 'Shareholder Report',       'desc' => 'Shareholder details and share allocation report',                'color' => '#26B99A', 'type' => 'default_shareholder'],
        ['icon' => 'fa-user',            'title' => 'Secretary Report',         'desc' => 'Company secretary listing and appointment details',              'color' => '#5cb85c', 'type' => 'comp_secretary_default'],
        ['icon' => 'fa-calendar-check-o','title' => 'AGM Report',               'desc' => 'Annual General Meeting dates, due dates and compliance',         'color' => '#f27b53', 'type' => 'agm_overdue'],
        ['icon' => 'fa-file-text',       'title' => 'AR Report',                'desc' => 'Annual Return filing status and dates report',                   'color' => '#E74C3C', 'type' => 'key_dates'],
        ['icon' => 'fa-calendar',        'title' => 'FYE Report',               'desc' => 'Financial Year End dates and upcoming deadlines',                'color' => '#f0ad4e', 'type' => 'remainder_upcoming_event'],
        ['icon' => 'fa-money',           'title' => 'Share Capital Report',     'desc' => 'Issued and paid-up share capital across companies',              'color' => '#9B59B6', 'type' => 'register_of_shares_allotment'],
        ['icon' => 'fa-exchange',        'title' => 'Share Transfer Report',    'desc' => 'History of share transfers and changes',                         'color' => '#3498DB', 'type' => 'register_of_shares_transfers'],
        ['icon' => 'fa-plus-circle',     'title' => 'Share Allotment Report',   'desc' => 'New share allotments and issuances',                             'color' => '#1ABC9C', 'type' => 'register_of_shares_allotment_transaction_date'],
        ['icon' => 'fa-map-marker',      'title' => 'Registered Address Report','desc' => 'All company registered addresses and changes',                   'color' => '#2C3E50', 'type' => 'registered_office_default'],
        ['icon' => 'fa-shield',          'title' => 'Auditor Report',           'desc' => 'Company auditor appointments and details',                       'color' => '#8E44AD', 'type' => 'register_of_auditors'],
        ['icon' => 'fa-gavel',           'title' => 'Resolution Report',        'desc' => 'Board and member resolutions record',                            'color' => '#D35400', 'type' => 'company_event'],
        ['icon' => 'fa-university',      'title' => 'Company Bank Report',      'desc' => 'Company bank account details listing',                           'color' => '#27AE60', 'type' => 'comp_client_default'],
        ['icon' => 'fa-clock-o',         'title' => 'Due Date Report',          'desc' => 'Upcoming compliance due dates tracker',                          'color' => '#C0392B', 'type' => 'remainder_upcoming_event'],
        ['icon' => 'fa-stamp',           'title' => 'Sealing Report',           'desc' => 'Register of sealing records',                                    'color' => '#7F8C8D', 'type' => 'register_of_sealings'],
        ['icon' => 'fa-id-card',         'title' => 'Contact Person Report',    'desc' => 'All company contact persons and details',                        'color' => '#2980B9', 'type' => 'comp_contact_default'],
        ['icon' => 'fa-flag',            'title' => 'Country Report',           'desc' => 'Companies grouped by country of incorporation',                  'color' => '#16A085', 'type' => 'acra_companies_search'],
        ['icon' => 'fa-bar-chart',       'title' => 'Status Report',            'desc' => 'Company status distribution and summary',                        'color' => '#F39C12', 'type' => 'event_specific'],
        ['icon' => 'fa-certificate',     'title' => 'Registration Report',      'desc' => 'Company registration details and compliance',                    'color' => '#E67E22', 'type' => 'register_of_charges'],
        ['icon' => 'fa-warning',         'title' => 'Risk Assessment Report',   'desc' => 'Company risk assessment ratings and AML checks',                 'color' => '#E74C3C', 'type' => 'default_company_controllers'],
        ['icon' => 'fa-history',         'title' => 'Incorporation Report',     'desc' => 'New incorporations within date range',                           'color' => '#3498DB', 'type' => 'change_of_company_name'],
        ['icon' => 'fa-birthday-cake',   'title' => 'Anniversary Report',       'desc' => 'Company incorporation anniversary dates',                        'color' => '#E91E63', 'type' => 'company_hierarchy'],
        ['icon' => 'fa-id-badge',        'title' => 'ID Expiry Report',         'desc' => 'Directors and members with expiring identity documents',          'color' => '#FF5722', 'type' => 'id_expiry_date'],
    ];
    foreach ($css_report_types as $report):
    ?>
    <div class="col-md-3 col-sm-4 col-xs-6" style="margin-bottom:15px;">
        <a href="<?= base_url('report_view/' . $report['type']) ?>" style="text-decoration:none;">
            <div class="x_panel" style="cursor:pointer;min-height:180px;transition:all 0.3s;">
                <div class="x_content" style="text-align:center;padding:20px 10px;">
                    <div style="width:50px;height:50px;border-radius:50%;background:<?= $report['color'] ?>;display:inline-flex;align-items:center;justify-content:center;margin-bottom:10px;">
                        <i class="fa <?= $report['icon'] ?>" style="color:#fff;font-size:20px;"></i>
                    </div>
                    <h4 style="color:<?= $report['color'] ?>;font-size:13px;font-weight:bold;"><?= $report['title'] ?></h4>
                    <p style="font-size:11px;color:#999;margin:0;"><?= $report['desc'] ?></p>
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
