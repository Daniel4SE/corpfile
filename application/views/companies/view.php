<!-- Company Detail View Page -->
<style>
    .nav-tabs.bar_tabs > li > a {
        padding: 8px 12px;
        font-size: 12px;
        white-space: nowrap;
    }
    .bar_tabs-wrapper {
        padding-top: 4px;
        overflow-x: auto;
        overflow-y: visible;
    }
    .nav-tabs.bar_tabs {
        flex-wrap: nowrap;
        overflow: visible;
        display: flex;
        min-width: max-content;
        border-bottom: 1px solid #ddd;
        margin-bottom: 0;
    }
    .nav-tabs.bar_tabs > li {
        flex-shrink: 0;
    }
    .company-detail .form-group {
        margin-bottom: 10px;
    }
    .company-detail .control-label {
        text-align: right;
        padding-top: 5px;
        font-size: 13px;
        color: #555;
    }
    .company-detail .form-control-static {
        font-size: 13px;
        min-height: 20px;
        padding-top: 5px;
    }
    .section-header {
        background: #f5f5f5;
        padding: 8px 15px;
        margin: 15px 0 10px 0;
        border-left: 3px solid #206570;
        font-weight: 600;
        font-size: 14px;
        color: #333;
    }
    .status-badge-active { background: #26B99A; color: #fff; }
    .status-badge-ceased { background: #E74C3C; color: #fff; }
    .status-badge-pending { background: #F0AD4E; color: #fff; }
    .tab-pane .btn-add-record {
        margin-bottom: 15px;
    }
    .tab-pane table thead tr {
        background: #206570;
        color: #fff;
    }
    .address-card {
        border: 1px solid #e5e5e5;
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 10px;
        background: #fafafa;
    }
    .address-card .address-type {
        font-weight: 600;
        color: #206570;
        margin-bottom: 5px;
    }
    .address-card .default-badge {
        display: inline-block;
        background: #26B99A;
        color: #fff;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 11px;
        margin-left: 8px;
    }
</style>

<div class="page-title">
    <div class="title_left">
        <h3>View Company - <?= htmlspecialchars($company->company_name) ?></h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <a href="<?= base_url('edit_company/' . $company->id . '/?comp') ?>" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            <a href="<?= base_url('company_list') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to List</a>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">

                <!-- Tab Navigation -->
                <div class="bar_tabs-wrapper">
                <ul class="nav nav-tabs bar_tabs" id="companyTabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#tab_company" role="tab" data-toggle="tab" aria-controls="tab_company">
                            <i class="fa fa-building"></i> Company
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_directors" role="tab" data-toggle="tab" aria-controls="tab_directors">
                            <i class="fa fa-users"></i> Directors
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_shareholders" role="tab" data-toggle="tab" aria-controls="tab_shareholders">
                            <i class="fa fa-pie-chart"></i> Shareholders
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_ubo" role="tab" data-toggle="tab" aria-controls="tab_ubo">
                            <i class="fa fa-eye"></i> UBO
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_secretaries" role="tab" data-toggle="tab" aria-controls="tab_secretaries">
                            <i class="fa fa-user-secret"></i> Secretaries
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_auditors" role="tab" data-toggle="tab" aria-controls="tab_auditors">
                            <i class="fa fa-search"></i> Auditors
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_controllers" role="tab" data-toggle="tab" aria-controls="tab_controllers">
                            <i class="fa fa-sitemap"></i> Controllers
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_contact_person" role="tab" data-toggle="tab" aria-controls="tab_contact_person">
                            <i class="fa fa-phone"></i> Contact Person
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_chairperson" role="tab" data-toggle="tab" aria-controls="tab_chairperson">
                            <i class="fa fa-user"></i> Chairperson
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_dpos" role="tab" data-toggle="tab" aria-controls="tab_dpos">
                            <i class="fa fa-shield"></i> DPOs
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_representatives" role="tab" data-toggle="tab" aria-controls="tab_representatives">
                            <i class="fa fa-id-badge"></i> Representatives
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_files" role="tab" data-toggle="tab" aria-controls="tab_files">
                            <i class="fa fa-folder-open"></i> Files
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_log" role="tab" data-toggle="tab" aria-controls="tab_log">
                            <i class="fa fa-history"></i> Log
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_ceos" role="tab" data-toggle="tab" aria-controls="tab_ceos">
                            <i class="fa fa-briefcase"></i> CEOs
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_nominees" role="tab" data-toggle="tab" aria-controls="tab_nominees">
                            <i class="fa fa-user-plus"></i> Nominees
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_others" role="tab" data-toggle="tab" aria-controls="tab_others">
                            <i class="fa fa-ellipsis-h"></i> Others
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_ep" role="tab" data-toggle="tab" aria-controls="tab_ep">
                            <i class="fa fa-id-card"></i> EP
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_dp" role="tab" data-toggle="tab" aria-controls="tab_dp">
                            <i class="fa fa-users"></i> DP
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_spass" role="tab" data-toggle="tab" aria-controls="tab_spass">
                            <i class="fa fa-id-badge"></i> S Pass
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_wp" role="tab" data-toggle="tab" aria-controls="tab_wp">
                            <i class="fa fa-briefcase"></i> WP
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tab_otherpass" role="tab" data-toggle="tab" aria-controls="tab_otherpass">
                            <i class="fa fa-passport"></i> Passes
                        </a>
                    </li>
                </ul>
                </div><!-- /.bar_tabs-wrapper -->

                <!-- Tab Content -->
                <div class="tab-content">

                    <!-- ============================================================= -->
                    <!-- TAB 1: COMPANY PROFILE -->
                    <!-- ============================================================= -->
                    <div id="tab_company" class="tab-pane fade in active" role="tabpanel">
                        <div class="company-detail">

                            <!-- Company Information -->
                            <div class="section-header">
                                <i class="fa fa-info-circle"></i> Company Information
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Company Name:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= htmlspecialchars($company->company_name ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Former Name:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= htmlspecialchars($company->former_name ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Client ID:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= htmlspecialchars($company->company_id_code ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Company Type:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= htmlspecialchars($company->company_type_name ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Registration No.:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= htmlspecialchars($company->registration_number ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>ACRA Registration No.:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= htmlspecialchars($company->acra_registration_number ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Country:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= htmlspecialchars($company->country ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Incorporation Date:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?= !empty($company->incorporation_date) ? date('d M Y', strtotime($company->incorporation_date)) : '' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Information -->
                            <div class="section-header">
                                <i class="fa fa-flag"></i> Status Information
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Entity Status:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php
                                                $entity_status = $company->entity_status ?? 'Active';
                                                $entity_label_class = 'label-success';
                                                if ($entity_status === 'Struck Off' || $entity_status === 'Dissolved') {
                                                    $entity_label_class = 'label-danger';
                                                } elseif ($entity_status === 'Pending') {
                                                    $entity_label_class = 'label-warning';
                                                }
                                                ?>
                                                <span class="label <?= $entity_label_class ?>"><?= htmlspecialchars($entity_status) ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Internal CSS Status:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <span class="label label-info"><?= htmlspecialchars($company->internal_css_status ?? '') ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Client Classification:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php if (!empty($company->is_client)): ?>
                                                    <span class="label label-success">Client</span>
                                                <?php endif; ?>
                                                <?php if (!empty($company->is_prospect)): ?>
                                                    <span class="label label-warning">Prospect</span>
                                                <?php endif; ?>
                                                <?php if (!empty($company->is_non_client)): ?>
                                                    <span class="label label-danger">Non-Client</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Risk Assessment:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php
                                                $risk = $company->risk_assessment_rating ?? '';
                                                $risk_class = 'label-default';
                                                if (strtolower($risk) === 'high') $risk_class = 'label-danger';
                                                elseif (strtolower($risk) === 'medium') $risk_class = 'label-warning';
                                                elseif (strtolower($risk) === 'low') $risk_class = 'label-success';
                                                ?>
                                                <?php if (!empty($risk)): ?>
                                                    <span class="label <?= $risk_class ?>"><?= htmlspecialchars($risk) ?></span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Common Seal:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php if (!empty($company->common_seal)): ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php else: ?>
                                                    <span class="label label-default">No</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Company Stamp:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php if (!empty($company->company_stamp)): ?>
                                                    <span class="label label-success">Yes</span>
                                                <?php else: ?>
                                                    <span class="label label-default">No</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Share Capital -->
                            <div class="section-header">
                                <i class="fa fa-money"></i> Share Capital
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <h5 style="color:#206570;margin:10px 0 5px 15px;font-weight:600;">Ordinary Shares</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Issued Share Capital:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?= htmlspecialchars($company->ord_currency ?? '') ?>
                                                <?= !empty($company->ord_issued_share_capital) ? number_format($company->ord_issued_share_capital, 2) : '' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>No. of Shares:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?= !empty($company->no_ord_shares) ? number_format($company->no_ord_shares) : '' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Paid-up Capital:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?= htmlspecialchars($company->ord_currency ?? '') ?>
                                                <?= !empty($company->paid_up_capital) ? number_format($company->paid_up_capital, 2) : '' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-12">
                                    <h5 style="color:#206570;margin:10px 0 5px 15px;font-weight:600;">Special/Preference Shares</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Issued Share Capital:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?= htmlspecialchars($company->spec_currency ?? '') ?>
                                                <?= !empty($company->spec_issued_share_capital) ? number_format($company->spec_issued_share_capital, 2) : '' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>No. of Shares:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?= !empty($company->no_spec_shares) ? number_format($company->no_spec_shares) : '' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Key Dates -->
                            <div class="section-header">
                                <i class="fa fa-calendar"></i> Key Dates
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>FYE Date:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?= !empty($company->fye_date) ? date('d M Y', strtotime($company->fye_date)) : '' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Next AGM Due:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?= !empty($company->next_agm_due) ? date('d M Y', strtotime($company->next_agm_due)) : '' ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FYE/AGM/AR Events -->
                            <?php if (!empty($events)): ?>
                            <div class="row" style="margin-top:10px;">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-condensed" style="font-size:12px;">
                                        <thead>
                                            <tr style="background:#206570;color:#fff;">
                                                <th>FYE Date</th>
                                                <th>AGM Date</th>
                                                <th>AR Date</th>
                                                <th>AR Filing Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($events as $evt): ?>
                                            <tr>
                                                <td><?= !empty($evt->fye_date) ? date('d M Y', strtotime($evt->fye_date)) : '' ?></td>
                                                <td><?= !empty($evt->agm_date) ? date('d M Y', strtotime($evt->agm_date)) : '' ?></td>
                                                <td><?= !empty($evt->ar_date) ? date('d M Y', strtotime($evt->ar_date)) : '' ?></td>
                                                <td><?= !empty($evt->ar_filing_date) ? date('d M Y', strtotime($evt->ar_filing_date)) : '' ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Contact Information -->
                            <div class="section-header">
                                <i class="fa fa-envelope"></i> Contact Information
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Phone:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static"><?= htmlspecialchars($company->phone1_number ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Email:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php if (!empty($company->email)): ?>
                                                    <a href="mailto:<?= htmlspecialchars($company->email) ?>"><?= htmlspecialchars($company->email) ?></a>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-horizontal">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><strong>Website:</strong></label>
                                        <div class="col-md-8">
                                            <p class="form-control-static">
                                                <?php if (!empty($company->website)): ?>
                                                    <a href="<?= htmlspecialchars($company->website) ?>" target="_blank"><?= htmlspecialchars($company->website) ?></a>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>

                            <!-- Addresses -->
                            <div class="section-header">
                                <i class="fa fa-map-marker"></i> Addresses
                            </div>
                            <div class="row" style="padding:0 15px;">
                                <?php if (!empty($addresses)): ?>
                                    <?php foreach ($addresses as $addr): ?>
                                    <div class="col-md-6">
                                        <div class="address-card">
                                            <div class="address-type">
                                                <?= htmlspecialchars($addr->address_type ?? 'Address') ?>
                                                <?php if (!empty($addr->is_default)): ?>
                                                    <span class="default-badge">Default</span>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <?php
                                                $parts = array_filter([
                                                    !empty($addr->block) ? 'Blk ' . $addr->block : '',
                                                    $addr->address_text ?? '',
                                                    $addr->building ?? '',
                                                ]);
                                                echo htmlspecialchars(implode(', ', $parts));
                                                ?>
                                            </div>
                                            <?php if (!empty($addr->level) || !empty($addr->unit)): ?>
                                            <div>
                                                <?php
                                                $levelUnit = [];
                                                if (!empty($addr->level)) $levelUnit[] = '#' . $addr->level;
                                                if (!empty($addr->unit)) $levelUnit[] = $addr->unit;
                                                echo htmlspecialchars(implode('-', $levelUnit));
                                                ?>
                                            </div>
                                            <?php endif; ?>
                                            <div>
                                                <?php
                                                $locParts = array_filter([
                                                    $addr->city ?? '',
                                                    $addr->state ?? '',
                                                    $addr->postal_code ?? '',
                                                ]);
                                                echo htmlspecialchars(implode(' ', $locParts));
                                                ?>
                                            </div>
                                            <?php if (!empty($addr->country)): ?>
                                            <div><?= htmlspecialchars($addr->country) ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-md-12">
                                        <p class="text-muted" style="padding:10px 0;">No addresses found.</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Remarks -->
                            <div class="section-header">
                                <i class="fa fa-comment"></i> Remarks
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="padding:10px 30px;">
                                    <p style="white-space:pre-wrap;font-size:13px;"><?= htmlspecialchars($company->remarks ?? '') ?></p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- END TAB 1: COMPANY PROFILE -->


                    <!-- ============================================================= -->
                    <!-- TAB 2: DIRECTORS -->
                    <!-- ============================================================= -->
                    <div id="tab_directors" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addDirector()">
                                <i class="fa fa-plus"></i> Add Director
                            </button>

                            <table id="dt_directors" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($directors)): ?>
                                        <?php $sno = 1; foreach ($directors as $dir): ?>
                                        <tr>
                                            <td><?= $sno++ ?></td>
                                            <td><?= htmlspecialchars($dir->name ?? '') ?></td>
                                            <td><?= htmlspecialchars($dir->id_type ?? '') ?></td>
                                            <td><?= htmlspecialchars($dir->id_number ?? '') ?></td>
                                            <td><?= htmlspecialchars($dir->nationality ?? '') ?></td>
                                            <td><?= !empty($dir->date_of_appointment) ? date('d M Y', strtotime($dir->date_of_appointment)) : '' ?></td>
                                            <td><?= !empty($dir->date_of_cessation) ? date('d M Y', strtotime($dir->date_of_cessation)) : '' ?></td>
                                            <td>
                                                <?php
                                                $dir_status = $dir->status ?? 'Active';
                                                $dir_label = strtolower($dir_status) === 'active' ? 'label-success' : 'label-danger';
                                                ?>
                                                <span class="label <?= $dir_label ?>"><?= htmlspecialchars($dir_status) ?></span>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-xs" onclick="editDirector('<?= $dir->id ?? '' ?>')" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button class="btn btn-danger btn-xs" onclick="deleteRecord('director', '<?= $dir->id ?? '' ?>')" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 2: DIRECTORS -->


                    <!-- ============================================================= -->
                    <!-- TAB 3: SHAREHOLDERS -->
                    <!-- ============================================================= -->
                    <div id="tab_shareholders" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addShareholder()">
                                <i class="fa fa-plus"></i> Add Shareholder
                            </button>

                            <table id="dt_shareholders" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Shareholder Type</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($shareholders)): ?>
                                        <?php $sno = 1; foreach ($shareholders as $sh): ?>
                                        <tr>
                                            <td><?= $sno++ ?></td>
                                            <td><?= htmlspecialchars($sh->shareholder_type ?? '') ?></td>
                                            <td><?= htmlspecialchars($sh->name ?? '') ?></td>
                                            <td><?= htmlspecialchars($sh->id_type ?? '') ?></td>
                                            <td><?= htmlspecialchars($sh->id_number ?? '') ?></td>
                                            <td><?= htmlspecialchars($sh->nationality ?? '') ?></td>
                                            <td><?= !empty($sh->date_of_appointment) ? date('d M Y', strtotime($sh->date_of_appointment)) : '' ?></td>
                                            <td>
                                                <?php
                                                $sh_status = $sh->status ?? 'Active';
                                                $sh_label = strtolower($sh_status) === 'active' ? 'label-success' : 'label-danger';
                                                ?>
                                                <span class="label <?= $sh_label ?>"><?= htmlspecialchars($sh_status) ?></span>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-xs" onclick="editShareholder('<?= $sh->id ?? '' ?>')" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button class="btn btn-danger btn-xs" onclick="deleteRecord('shareholder', '<?= $sh->id ?? '' ?>')" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 3: SHAREHOLDERS -->


                    <!-- ============================================================= -->
                    <!-- TAB 4: UBO (Ultimate Beneficial Owners) -->
                    <!-- ============================================================= -->
                    <div id="tab_ubo" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addUBO()">
                                <i class="fa fa-plus"></i> Add UBO
                            </button>

                            <table id="dt_ubo" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Type of Control</th>
                                        <th>Date of Entry</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 4: UBO -->


                    <!-- ============================================================= -->
                    <!-- TAB 5: SECRETARIES -->
                    <!-- ============================================================= -->
                    <div id="tab_secretaries" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addSecretary()">
                                <i class="fa fa-plus"></i> Add Secretary
                            </button>

                            <table id="dt_secretaries" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($secretaries)): ?>
                                        <?php $sno = 1; foreach ($secretaries as $sec): ?>
                                        <tr>
                                            <td><?= $sno++ ?></td>
                                            <td><?= htmlspecialchars($sec->name ?? '') ?></td>
                                            <td><?= htmlspecialchars($sec->id_type ?? '') ?></td>
                                            <td><?= htmlspecialchars($sec->id_number ?? '') ?></td>
                                            <td><?= htmlspecialchars($sec->nationality ?? '') ?></td>
                                            <td><?= !empty($sec->date_of_appointment) ? date('d M Y', strtotime($sec->date_of_appointment)) : '' ?></td>
                                            <td><?= !empty($sec->date_of_cessation) ? date('d M Y', strtotime($sec->date_of_cessation)) : '' ?></td>
                                            <td>
                                                <?php
                                                $sec_status = $sec->status ?? 'Active';
                                                $sec_label = strtolower($sec_status) === 'active' ? 'label-success' : 'label-danger';
                                                ?>
                                                <span class="label <?= $sec_label ?>"><?= htmlspecialchars($sec_status) ?></span>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-xs" onclick="editSecretary('<?= $sec->id ?? '' ?>')" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button class="btn btn-danger btn-xs" onclick="deleteRecord('secretary', '<?= $sec->id ?? '' ?>')" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 5: SECRETARIES -->


                    <!-- ============================================================= -->
                    <!-- TAB 6: AUDITORS -->
                    <!-- ============================================================= -->
                    <div id="tab_auditors" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addAuditor()">
                                <i class="fa fa-plus"></i> Add Auditor
                            </button>

                            <table id="dt_auditors" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>Firm Name</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($auditors)): ?>
                                        <?php $sno = 1; foreach ($auditors as $aud): ?>
                                        <tr>
                                            <td><?= $sno++ ?></td>
                                            <td><?= htmlspecialchars($aud->name ?? '') ?></td>
                                            <td><?= htmlspecialchars($aud->firm_name ?? '') ?></td>
                                            <td><?= !empty($aud->date_of_appointment) ? date('d M Y', strtotime($aud->date_of_appointment)) : '' ?></td>
                                            <td><?= !empty($aud->date_of_cessation) ? date('d M Y', strtotime($aud->date_of_cessation)) : '' ?></td>
                                            <td>
                                                <?php
                                                $aud_status = $aud->status ?? 'Active';
                                                $aud_label = strtolower($aud_status) === 'active' ? 'label-success' : 'label-danger';
                                                ?>
                                                <span class="label <?= $aud_label ?>"><?= htmlspecialchars($aud_status) ?></span>
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-xs" onclick="editAuditor('<?= $aud->id ?? '' ?>')" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button class="btn btn-danger btn-xs" onclick="deleteRecord('auditor', '<?= $aud->id ?? '' ?>')" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 6: AUDITORS -->


                    <!-- ============================================================= -->
                    <!-- TAB 7: CONTROLLERS (Registrable Controllers) -->
                    <!-- ============================================================= -->
                    <div id="tab_controllers" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addController()">
                                <i class="fa fa-plus"></i> Add Controller
                            </button>

                            <table id="dt_controllers" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Type of Control</th>
                                        <th>Date of Entry</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 7: CONTROLLERS -->


                    <!-- ============================================================= -->
                    <!-- TAB 8: CONTACT PERSON -->
                    <!-- ============================================================= -->
                    <div id="tab_contact_person" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addContactPerson()">
                                <i class="fa fa-plus"></i> Add Contact Person
                            </button>

                            <table id="dt_contact_person" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th>Remarks</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 8: CONTACT PERSON -->


                    <!-- ============================================================= -->
                    <!-- TAB 9: CHAIRPERSON -->
                    <!-- ============================================================= -->
                    <div id="tab_chairperson" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addChairperson()">
                                <i class="fa fa-plus"></i> Add Chairperson
                            </button>

                            <table id="dt_chairperson" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 9: CHAIRPERSON -->


                    <!-- ============================================================= -->
                    <!-- TAB 10: DPOs (Data Protection Officers) -->
                    <!-- ============================================================= -->
                    <div id="tab_dpos" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addDPO()">
                                <i class="fa fa-plus"></i> Add DPO
                            </button>

                            <table id="dt_dpos" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 10: DPOs -->


                    <!-- ============================================================= -->
                    <!-- TAB 11: REPRESENTATIVES -->
                    <!-- ============================================================= -->
                    <div id="tab_representatives" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addRepresentative()">
                                <i class="fa fa-plus"></i> Add Representative
                            </button>

                            <table id="dt_representatives" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Role</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 11: REPRESENTATIVES -->


                    <!-- ============================================================= -->
                    <!-- TAB 12: FILES -->
                    <!-- ============================================================= -->
                    <div id="tab_files" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <!-- File Upload Area -->
                            <div class="well" style="border:2px dashed #ccc;text-align:center;padding:25px;background:#fafafa;margin-bottom:15px;">
                                <form id="fileUploadForm" action="<?= base_url('companies/upload_file/' . $company->id) ?>" method="POST" enctype="multipart/form-data">
                                    <i class="fa fa-cloud-upload fa-3x" style="color:#aaa;"></i>
                                    <p style="margin:10px 0;color:#888;">Drag & drop files here or click to browse</p>
                                    <input type="file" id="fileInput" name="company_file" style="display:none;" multiple>
                                    <div>
                                        <label for="file_category" style="margin-right:10px;">Category:</label>
                                        <select name="file_category" id="file_category" class="form-control" style="width:200px;display:inline-block;">
                                            <option value="">-- Select --</option>
                                            <option value="incorporation">Incorporation</option>
                                            <option value="annual_return">Annual Return</option>
                                            <option value="resolution">Resolution</option>
                                            <option value="minutes">Minutes</option>
                                            <option value="certificate">Certificate</option>
                                            <option value="others">Others</option>
                                        </select>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="$('#fileInput').click();">
                                            <i class="fa fa-folder-open"></i> Browse Files
                                        </button>
                                        <button type="submit" class="btn btn-success btn-sm" id="btnUpload" style="display:none;">
                                            <i class="fa fa-upload"></i> Upload
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Files DataTable -->
                            <table id="dt_files" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>File Name</th>
                                        <th>Category</th>
                                        <th>Uploaded By</th>
                                        <th>Upload Date</th>
                                        <th width="140">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Files loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 12: FILES -->


                    <!-- ============================================================= -->
                    <!-- TAB 13: LOG (Activity Log) -->
                    <!-- ============================================================= -->
                    <div id="tab_log" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <table id="dt_log" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Action</th>
                                        <th>Description</th>
                                        <th>User</th>
                                        <th>Date/Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Log entries loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 13: LOG -->


                    <!-- ============================================================= -->
                    <!-- TAB 14: CEOs -->
                    <!-- ============================================================= -->
                    <div id="tab_ceos" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addCEO()">
                                <i class="fa fa-plus"></i> Add CEO
                            </button>

                            <table id="dt_ceos" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 14: CEOs -->


                    <!-- ============================================================= -->
                    <!-- TAB 15: NOMINEES -->
                    <!-- ============================================================= -->
                    <div id="tab_nominees" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addNominee()">
                                <i class="fa fa-plus"></i> Add Nominee
                            </button>

                            <table id="dt_nominees" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>Nominee Type</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 15: NOMINEES -->


                    <!-- ============================================================= -->
                    <!-- TAB 16: OTHERS -->
                    <!-- ============================================================= -->
                    <div id="tab_others" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addOther()">
                                <i class="fa fa-plus"></i> Add Record
                            </button>

                            <table id="dt_others" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th>Nationality</th>
                                        <th>Date of Appointment</th>
                                        <th>Date of Cessation</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 16: OTHERS -->


                    <!-- ============================================================= -->
                    <!-- TAB 17: EP -->
                    <!-- ============================================================= -->
                    <div id="tab_ep" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addEP()">
                                <i class="fa fa-plus"></i> Add Record
                            </button>

                            <table id="dt_ep" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Holder Name</th>
                                        <th>Pass Type</th>
                                        <th>FIN Number</th>
                                        <th>Nationality</th>
                                        <th>Issue Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 17: EP -->


                    <!-- ============================================================= -->
                    <!-- TAB 18: DP -->
                    <!-- ============================================================= -->
                    <div id="tab_dp" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addDP()">
                                <i class="fa fa-plus"></i> Add Record
                            </button>

                            <table id="dt_dp" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Holder Name</th>
                                        <th>Sponsor (EP Holder)</th>
                                        <th>FIN Number</th>
                                        <th>Nationality</th>
                                        <th>Issue Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 18: DP -->


                    <!-- ============================================================= -->
                    <!-- TAB 19: S PASS -->
                    <!-- ============================================================= -->
                    <div id="tab_spass" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addSPass()">
                                <i class="fa fa-plus"></i> Add Record
                            </button>

                            <table id="dt_spass" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Holder Name</th>
                                        <th>FIN Number</th>
                                        <th>Nationality</th>
                                        <th>Issue Date</th>
                                        <th>Expiry Date</th>
                                        <th>Quota Type</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 19: S PASS -->


                    <!-- ============================================================= -->
                    <!-- TAB 20: WORK PERMIT -->
                    <!-- ============================================================= -->
                    <div id="tab_wp" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addWP()">
                                <i class="fa fa-plus"></i> Add Record
                            </button>

                            <table id="dt_wp" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Holder Name</th>
                                        <th>FIN Number</th>
                                        <th>Nationality</th>
                                        <th>Sector</th>
                                        <th>Issue Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 20: WORK PERMIT -->


                    <!-- ============================================================= -->
                    <!-- TAB 21: OTHER PASSES -->
                    <!-- ============================================================= -->
                    <div id="tab_otherpass" class="tab-pane fade" role="tabpanel">
                        <div style="margin-top:15px;">
                            <button class="btn btn-success btn-sm btn-add-record" onclick="addOtherPass()">
                                <i class="fa fa-plus"></i> Add Record
                            </button>

                            <table id="dt_otherpass" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="40">S/No</th>
                                        <th>Holder Name</th>
                                        <th>Pass Type</th>
                                        <th>Pass Number</th>
                                        <th>Nationality</th>
                                        <th>Issue Date</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th width="100">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- No records placeholder - populated via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END TAB 21: OTHER PASSES -->

                </div>
                <!-- End Tab Content -->

            </div>
        </div>
    </div>
</div>


<!-- ================================================================= -->
<!-- MODAL: Generic Add/Edit Modal (reused across tabs) -->
<!-- ================================================================= -->
<div class="modal fade" id="recordModal" tabindex="-1" role="dialog" aria-labelledby="recordModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#206570;color:#fff;">
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">&times;</button>
                <h4 class="modal-title" id="recordModalLabel">Add Record</h4>
            </div>
            <div class="modal-body" id="recordModalBody">
                <!-- Dynamic content loaded via AJAX -->
                <div class="text-center" style="padding:40px;">
                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                    <p>Loading...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnSaveRecord">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>


<!-- ================================================================= -->
<!-- JAVASCRIPT -->
<!-- ================================================================= -->
<script>
var companyId = '<?= $company->id ?>';
var BASE_URL = '<?= base_url() ?>';

$(document).ready(function() {

    // ---------------------------------------------------------------
    // Initialize DataTables
    // ---------------------------------------------------------------
    var dtOptions = {
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'asc']],
        responsive: true,
        language: {
            emptyTable: "No records found",
            zeroRecords: "No matching records found"
        }
    };

    if ($.fn.DataTable) {
        // Directors
        var dtDirectors = $('#dt_directors').DataTable(dtOptions);

        // Shareholders
        var dtShareholders = $('#dt_shareholders').DataTable(dtOptions);

        // UBO
        var dtUBO = $('#dt_ubo').DataTable(dtOptions);

        // Secretaries
        var dtSecretaries = $('#dt_secretaries').DataTable(dtOptions);

        // Auditors
        var dtAuditors = $('#dt_auditors').DataTable(dtOptions);

        // Controllers
        var dtControllers = $('#dt_controllers').DataTable(dtOptions);

        // Contact Person
        var dtContactPerson = $('#dt_contact_person').DataTable(dtOptions);

        // Chairperson
        var dtChairperson = $('#dt_chairperson').DataTable(dtOptions);

        // DPOs
        var dtDPOs = $('#dt_dpos').DataTable(dtOptions);

        // Representatives
        var dtRepresentatives = $('#dt_representatives').DataTable(dtOptions);

        // Files
        var dtFiles = $('#dt_files').DataTable($.extend({}, dtOptions, {
            order: [[4, 'desc']]
        }));

        // Log
        var dtLog = $('#dt_log').DataTable($.extend({}, dtOptions, {
            order: [[4, 'desc']]
        }));

        // CEOs
        var dtCEOs = $('#dt_ceos').DataTable(dtOptions);

        // Nominees
        var dtNominees = $('#dt_nominees').DataTable(dtOptions);

        // Others
        var dtOthers = $('#dt_others').DataTable(dtOptions);
    }

    // ---------------------------------------------------------------
    // Tab switching - redraw DataTables on tab show (fixes column width)
    // ---------------------------------------------------------------
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        if ($.fn.DataTable) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        }
    });

    // ---------------------------------------------------------------
    // File Upload handling
    // ---------------------------------------------------------------
    $('#fileInput').on('change', function() {
        if (this.files.length > 0) {
            $('#btnUpload').show();
            var names = [];
            for (var i = 0; i < this.files.length; i++) {
                names.push(this.files[i].name);
            }
            $(this).closest('.well').find('p').text('Selected: ' + names.join(', '));
        }
    });

    // Drag and drop
    var dropZone = $('#fileUploadForm').closest('.well');
    dropZone.on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).css('border-color', '#206570');
    });
    dropZone.on('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).css('border-color', '#ccc');
    });
    dropZone.on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).css('border-color', '#ccc');
        var files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            $('#fileInput')[0].files = files;
            $('#fileInput').trigger('change');
        }
    });

    // AJAX file upload
    $('#fileUploadForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#btnUpload').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Uploading...');
            },
            success: function(response) {
                showAlert('success', 'File uploaded successfully.');
                loadFiles();
                // Reset form
                $('#fileUploadForm')[0].reset();
                $('#btnUpload').hide().prop('disabled', false).html('<i class="fa fa-upload"></i> Upload');
                dropZone.find('p').text('Drag & drop files here or click to browse');
            },
            error: function(xhr) {
                showAlert('error', 'Failed to upload file. Please try again.');
                $('#btnUpload').prop('disabled', false).html('<i class="fa fa-upload"></i> Upload');
            }
        });
    });

    // ---------------------------------------------------------------
    // Load activity log via AJAX
    // ---------------------------------------------------------------
    loadActivityLog();
    loadFiles();

    // ---------------------------------------------------------------
    // Hash-based tab navigation (for direct linking)
    // ---------------------------------------------------------------
    var hash = window.location.hash;
    if (hash) {
        var tabLink = $('#companyTabs a[href="' + hash + '"]');
        if (tabLink.length) {
            tabLink.tab('show');
        }
    }
    // Update hash on tab change
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        history.replaceState(null, null, e.target.hash);
    });
});


// ===================================================================
// CRUD Functions - Directors
// ===================================================================
function addDirector() {
    loadModalForm('Add Director', BASE_URL + 'companies/director_form/' + companyId);
}

function editDirector(id) {
    loadModalForm('Edit Director', BASE_URL + 'companies/director_form/' + companyId + '/' + id);
}


// ===================================================================
// CRUD Functions - Shareholders
// ===================================================================
function addShareholder() {
    loadModalForm('Add Shareholder', BASE_URL + 'companies/shareholder_form/' + companyId);
}

function editShareholder(id) {
    loadModalForm('Edit Shareholder', BASE_URL + 'companies/shareholder_form/' + companyId + '/' + id);
}


// ===================================================================
// CRUD Functions - Secretaries
// ===================================================================
function addSecretary() {
    loadModalForm('Add Secretary', BASE_URL + 'companies/secretary_form/' + companyId);
}

function editSecretary(id) {
    loadModalForm('Edit Secretary', BASE_URL + 'companies/secretary_form/' + companyId + '/' + id);
}


// ===================================================================
// CRUD Functions - Auditors
// ===================================================================
function addAuditor() {
    loadModalForm('Add Auditor', BASE_URL + 'companies/auditor_form/' + companyId);
}

function editAuditor(id) {
    loadModalForm('Edit Auditor', BASE_URL + 'companies/auditor_form/' + companyId + '/' + id);
}


// ===================================================================
// CRUD Functions - Placeholder tabs
// ===================================================================
function addUBO() {
    loadModalForm('Add Ultimate Beneficial Owner', BASE_URL + 'companies/ubo_form/' + companyId);
}

function addController() {
    loadModalForm('Add Registrable Controller', BASE_URL + 'companies/controller_form/' + companyId);
}

function addContactPerson() {
    loadModalForm('Add Contact Person', BASE_URL + 'companies/contact_person_form/' + companyId);
}

function addChairperson() {
    loadModalForm('Add Chairperson', BASE_URL + 'companies/chairperson_form/' + companyId);
}

function addDPO() {
    loadModalForm('Add Data Protection Officer', BASE_URL + 'companies/dpo_form/' + companyId);
}

function addRepresentative() {
    loadModalForm('Add Representative', BASE_URL + 'companies/representative_form/' + companyId);
}

function addCEO() {
    loadModalForm('Add CEO', BASE_URL + 'companies/ceo_form/' + companyId);
}

function addNominee() {
    loadModalForm('Add Nominee', BASE_URL + 'companies/nominee_form/' + companyId);
}

function addOther() {
    loadModalForm('Add Record', BASE_URL + 'companies/other_form/' + companyId);
}

function addEP() {
    alert('Coming soon');
}

function editEP(id) {
    alert('Coming soon');
}

function deleteEP(id) {
    alert('Coming soon');
}

function addDP() {
    alert('Coming soon');
}

function editDP(id) {
    alert('Coming soon');
}

function deleteDP(id) {
    alert('Coming soon');
}

function addSPass() {
    alert('Coming soon');
}

function editSPass(id) {
    alert('Coming soon');
}

function deleteSPass(id) {
    alert('Coming soon');
}

function addWP() {
    alert('Coming soon');
}

function editWP(id) {
    alert('Coming soon');
}

function deleteWP(id) {
    alert('Coming soon');
}

function addOtherPass() {
    alert('Coming soon');
}

function editOtherPass(id) {
    alert('Coming soon');
}

function deleteOtherPass(id) {
    alert('Coming soon');
}


// ===================================================================
// Generic Modal Form Loader
// ===================================================================
function loadModalForm(title, url) {
    $('#recordModalLabel').text(title);
    $('#recordModalBody').html(
        '<div class="text-center" style="padding:40px;">' +
        '<i class="fa fa-spinner fa-spin fa-2x"></i>' +
        '<p>Loading...</p></div>'
    );
    $('#recordModal').modal('show');

    $.ajax({
        url: url,
        type: 'GET',
        success: function(html) {
            $('#recordModalBody').html(html);
            // Re-initialize select2 and datepickers inside modal
            if ($.fn.select2) {
                $('#recordModal .select2').select2({ dropdownParent: $('#recordModal') });
            }
            if ($.fn.datepicker) {
                $('#recordModal .datepicker').datepicker({ format: 'dd/mm/yyyy', autoclose: true });
            }
        },
        error: function() {
            $('#recordModalBody').html(
                '<div class="alert alert-danger">' +
                '<i class="fa fa-exclamation-circle"></i> Failed to load form. Please try again.' +
                '</div>'
            );
        }
    });
}


// ===================================================================
// Save Record (Generic)
// ===================================================================
$('#btnSaveRecord').on('click', function() {
    var form = $('#recordModalBody form');
    if (form.length === 0) {
        showAlert('error', 'No form found.');
        return;
    }

    var url = form.attr('action');
    var data = form.serialize();

    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        beforeSend: function() {
            $('#btnSaveRecord').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        },
        success: function(response) {
            try {
                var res = typeof response === 'string' ? JSON.parse(response) : response;
                if (res.status === 'success' || res.success) {
                    showAlert('success', res.message || 'Record saved successfully.');
                    $('#recordModal').modal('hide');
                    // Reload page to refresh data
                    setTimeout(function() { location.reload(); }, 1000);
                } else {
                    showAlert('error', res.message || 'Failed to save record.');
                }
            } catch (e) {
                // If response is HTML (redirect), reload
                showAlert('success', 'Record saved successfully.');
                $('#recordModal').modal('hide');
                setTimeout(function() { location.reload(); }, 1000);
            }
        },
        error: function(xhr) {
            var msg = 'Failed to save record.';
            try {
                var res = JSON.parse(xhr.responseText);
                msg = res.message || msg;
            } catch (e) {}
            showAlert('error', msg);
        },
        complete: function() {
            $('#btnSaveRecord').prop('disabled', false).html('<i class="fa fa-save"></i> Save');
        }
    });
});


// ===================================================================
// Delete Record (Generic with SweetAlert)
// ===================================================================
function deleteRecord(type, id) {
    var url = BASE_URL + 'companies/delete_' + type + '/' + id;
    var typeName = type.charAt(0).toUpperCase() + type.slice(1);

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete ' + typeName + '?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                performDelete(url, typeName);
            }
        });
    } else if (confirm('Are you sure you want to delete this ' + type + '?')) {
        performDelete(url, typeName);
    }
}

function performDelete(url, typeName) {
    $.ajax({
        url: url,
        type: 'POST',
        data: { _method: 'DELETE' },
        success: function(response) {
            try {
                var res = typeof response === 'string' ? JSON.parse(response) : response;
                if (res.status === 'success' || res.success) {
                    showAlert('success', typeName + ' deleted successfully.');
                    setTimeout(function() { location.reload(); }, 1000);
                } else {
                    showAlert('error', res.message || 'Failed to delete record.');
                }
            } catch (e) {
                showAlert('success', typeName + ' deleted successfully.');
                setTimeout(function() { location.reload(); }, 1000);
            }
        },
        error: function() {
            showAlert('error', 'Failed to delete ' + typeName.toLowerCase() + '. Please try again.');
        }
    });
}


// ===================================================================
// File Actions
// ===================================================================
function loadFiles() {
    $.ajax({
        url: BASE_URL + 'companies/get_files/' + companyId,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if ($.fn.DataTable && $.fn.DataTable.isDataTable('#dt_files')) {
                var table = $('#dt_files').DataTable();
                table.clear();
                if (data && data.length > 0) {
                    $.each(data, function(i, file) {
                        table.row.add([
                            (i + 1),
                            '<i class="fa fa-file-o"></i> ' + escapeHtml(file.file_name),
                            escapeHtml(file.category || ''),
                            escapeHtml(file.uploaded_by || ''),
                            file.upload_date || '',
                            '<button class="btn btn-primary btn-xs" onclick="viewFile(\'' + file.id + '\')" title="View"><i class="fa fa-eye"></i></button> ' +
                            '<a href="' + BASE_URL + 'companies/download_file/' + file.id + '" class="btn btn-success btn-xs" title="Download"><i class="fa fa-download"></i></a> ' +
                            '<button class="btn btn-danger btn-xs" onclick="deleteFile(\'' + file.id + '\')" title="Delete"><i class="fa fa-trash"></i></button>'
                        ]);
                    });
                }
                table.draw();
            }
        },
        error: function() {
            // Silently fail - empty table will show "No records found"
        }
    });
}

function viewFile(fileId) {
    window.open(BASE_URL + 'companies/view_file/' + fileId, '_blank');
}

function deleteFile(fileId) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Delete File?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + 'companies/delete_file/' + fileId,
                    type: 'POST',
                    success: function() {
                        showAlert('success', 'File deleted successfully.');
                        loadFiles();
                    },
                    error: function() {
                        showAlert('error', 'Failed to delete file.');
                    }
                });
            }
        });
    } else if (confirm('Are you sure you want to delete this file?')) {
        $.ajax({
            url: BASE_URL + 'companies/delete_file/' + fileId,
            type: 'POST',
            success: function() {
                showAlert('success', 'File deleted successfully.');
                loadFiles();
            },
            error: function() {
                showAlert('error', 'Failed to delete file.');
            }
        });
    }
}


// ===================================================================
// Activity Log
// ===================================================================
function loadActivityLog() {
    $.ajax({
        url: BASE_URL + 'companies/get_activity_log/' + companyId,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if ($.fn.DataTable && $.fn.DataTable.isDataTable('#dt_log')) {
                var table = $('#dt_log').DataTable();
                table.clear();
                if (data && data.length > 0) {
                    $.each(data, function(i, log) {
                        var actionClass = 'label-info';
                        var action = (log.action || '').toLowerCase();
                        if (action === 'create' || action === 'add') actionClass = 'label-success';
                        else if (action === 'delete' || action === 'remove') actionClass = 'label-danger';
                        else if (action === 'update' || action === 'edit') actionClass = 'label-warning';

                        table.row.add([
                            (i + 1),
                            '<span class="label ' + actionClass + '">' + escapeHtml(log.action || '') + '</span>',
                            escapeHtml(log.description || ''),
                            escapeHtml(log.user || ''),
                            log.datetime || ''
                        ]);
                    });
                }
                table.draw();
            }
        },
        error: function() {
            // Silently fail - empty table will show "No records found"
        }
    });
}


// ===================================================================
// Utility Functions
// ===================================================================
function showAlert(type, message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: type === 'success' ? 'success' : 'error',
            title: type === 'success' ? 'Success' : 'Error',
            text: message,
            timer: type === 'success' ? 2000 : undefined,
            showConfirmButton: type !== 'success'
        });
    } else {
        alert(message);
    }
}

function escapeHtml(text) {
    if (!text) return '';
    var map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
}
</script>
