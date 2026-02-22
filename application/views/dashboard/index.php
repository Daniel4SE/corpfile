<!-- Dashboard Content -->
<div class="page-title">
    <div class="title_left">
        <h3>Dashboard</h3>
    </div>
</div>
<div class="clearfix"></div>

<!-- Stat Tiles -->
<div class="row top_tiles">
    <div class="col-md-12">
        <div class="row" style="display:flex;flex-wrap:wrap;">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:flex;">
                <div class="tile-stats allcompany" style="width:100%;min-height:95px;">
                    <a href="<?= base_url('company_list') ?>"><div class="icon"><i class="fa fa-building-o"></i></div></a>
                    <a href="<?= base_url('company_list') ?>"><div class="count"><?= $total_companies ?></div></a>
                    <a href="<?= base_url('company_list') ?>"><h3 style="margin-top:10px">Total Companies</h3></a>
                    <a href="<?= base_url('add_company') ?>" class="btn btn-success btn-xs" style="position:absolute;bottom:10px;right:10px;">
                        <i class="fa fa-plus"></i> Add Company
                    </a>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:flex;">
                <div class="tile-stats precompanys" style="width:100%;min-height:95px;">
                    <a href="<?= base_url('pre_company') ?>"><div class="icon"><i class="fa fa-pause"></i></div></a>
                    <a href="<?= base_url('pre_company') ?>"><div class="count"><?= $pre_incorp_count ?></div></a>
                    <a href="<?= base_url('pre_company') ?>"><h3 style="margin-top:10px">Pre Incorporation Company</h3></a>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:flex;">
                <div class="tile-stats postcompany" style="width:100%;min-height:95px;">
                    <a href="<?= base_url('post_company') ?>"><div class="icon"><i class="fa fa-check-circle"></i></div></a>
                    <a href="<?= base_url('post_company') ?>"><div class="count"><?= $post_incorp_count ?></div></a>
                    <a href="<?= base_url('post_company') ?>"><h3 style="margin-top:10px">Post Incorporation Company</h3></a>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:flex;">
                <div class="tile-stats" style="background:#5D6D8A !important;width:100%;min-height:95px;">
                    <a href="<?= base_url('company_non_client') ?>"><div class="icon"><i class="fa fa-building-o" style="color:#fff;"></i></div></a>
                    <a href="<?= base_url('company_non_client') ?>"><div class="count" style="color:#fff;"><?= $non_client_count ?></div></a>
                    <a href="<?= base_url('company_non_client') ?>"><h3 style="margin-top:10px;color:#fff !important;">Non-Client Company</h3></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Client Type Filter -->
<div class="row">
    <div class="col-md-12" id="dashboard_client_type">
        <label>Client Type:</label>
        <select class="form-control select2_multiple" id="select_client" multiple style="width:60%;display:inline-block;">
            <option value="1">Css Client</option>
            <option value="2">Taxation Client</option>
            <option value="3">Auditor</option>
            <option value="4">Corporate Shareholder</option>
            <option value="5">Fund Management</option>
            <option value="6">Accounting Client</option>
            <option value="7">Corporate Director</option>
            <option value="8">Corporate Owner</option>
            <option value="9">External Corp Sec</option>
            <option value="10">Audit Client</option>
            <option value="11">Prospect</option>
            <option value="12">Client</option>
        </select>
        <button class="btn btn-success" onclick="filterByClientType()">Submit</button>
    </div>
</div>
<br>

<!-- Alert Panels -->
<div class="row">
    <!-- AGM Due Alert -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title alertcolor">
                <h2 style="color:#fff;">AGM Due Alert (<?= count($agm_alerts) ?>)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="height:180px; overflow-y:scroll;">
                <ul class="list-unstyled msg_list" id="postList">
                    <?php if (!empty($agm_alerts)): ?>
                        <?php foreach ($agm_alerts as $alert): ?>
                        <li style="cursor:pointer;">
                            <a href="<?= base_url('view_company/' . $alert->id) ?>">
                                <span class="image"><img src="<?= base_url('public/images/img.jpg') ?>" alt="" style="width:40px;height:40px;border-radius:50%;"></span>
                                <span><span style="font-size:16px;"><?= htmlspecialchars($alert->company_name) ?></span></span>
                                <span class="message"><span>AGM Due: </span><?= $alert->agm_due_date ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><a><span class="message">No AGM alerts</span></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- AR Due Alert -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title alertcolor">
                <h2 style="color:#fff;">AR Due Alert (<span id="ar_count">0</span>)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="height:180px; overflow-y:scroll;">
                <ul class="list-unstyled msg_list" id="postList1">
                    <li><a><span class="message">No AR alerts</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Due Alert (Events) -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title alertcolor">
                <h2 style="color:#fff;">Due Alert (<span id="due_count">0</span>)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="height:180px; overflow-y:scroll;">
                <ul class="list-unstyled msg_list" id="postList2">
                    <li><a><span class="message">No due alerts</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- FYE Date Not Entered -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title alertcolor">
                <h2 style="color:#fff;">FYE Date Not Entered (<span id="fye_count">0</span>)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="height:180px; overflow-y:scroll;">
                <ul class="list-unstyled msg_list" id="postList3">
                    <li><a><span class="message">No alerts</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Incorporation Date Not Entered -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title alertcolor">
                <h2 style="color:#fff;">Incorporation Date Not Entered (<span id="incorp_count">0</span>)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="height:180px; overflow-y:scroll;">
                <ul class="list-unstyled msg_list" id="postList4">
                    <li><a><span class="message">No alerts</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Anniversary Due Alert -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title alertcolor">
                <h2 style="color:#fff;">Anniversary Due Alert (<span id="anniv_count">0</span>)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="height:180px; overflow-y:scroll;">
                <ul class="list-unstyled msg_list" id="postList5">
                    <li><a><span class="message">No alerts</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- ID Expiry Alert -->
    <div class="col-md-6">
        <div class="x_panel">
            <div class="x_title alertcolor">
                <h2 style="color:#fff;">ID Expiry Alert (<span id="expiry_count">0</span>)</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="height:180px; overflow-y:scroll;">
                <ul class="list-unstyled msg_list" id="postList6">
                    <li><a><span class="message">No alerts</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Calendar Section -->
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Event Calendar</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12">
                    <center>
                        AGM - <span style="border: 15px solid #337ab7;">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;
                        AR - <span style="border: 15px solid #f27b53;">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;
                        Resolution - <span style="border: 15px solid #feb300;">&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;
                        Events - <span style="border: 15px solid #5cb85c;">&nbsp;&nbsp;&nbsp;</span>
                    </center>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="form-group col-md-3">
                        <select class="form-control" id="yearFilter">
                            <?php for($y = 2020; $y <= 2031; $y++): ?>
                            <option value="<?= $y ?>" <?= $y == date('Y') ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select class="form-control" id="monthFilter">
                            <?php 
                            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                            foreach($months as $i => $m): ?>
                            <option value="<?= $i+1 ?>" <?= ($i+1) == date('n') ? 'selected' : '' ?>><?= $m ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize select2
    if ($.fn.select2) {
        $('.select2_multiple').select2();
    }
    
    // Initialize fullcalendar
    if ($.fn.fullCalendar) {
        $('#calendar').fullCalendar({
            header: {
                left: '',
                center: 'title',
                right: ''
            },
            defaultDate: '<?= date("Y-m") ?>',
            navLinks: true,
            editable: false,
            eventLimit: true,
            events: <?= json_encode(array_map(function($e) {
                $colors = ['AGM' => '#337ab7', 'AR' => '#f27b53', 'Resolution' => '#feb300', 'Event' => '#5cb85c'];
                return [
                    'title' => $e->company_name ?? 'Event',
                    'start' => $e->event_date ?? $e->agm_due_date ?? '',
                    'backgroundColor' => $colors[$e->event_type ?? 'Event'] ?? '#337ab7',
                    'borderColor' => $colors[$e->event_type ?? 'Event'] ?? '#337ab7',
                ];
            }, $calendar_events ?? [])) ?>,
            eventClick: function(event) {
                alert('Event: ' + event.title);
            }
        });
    }
});

function filterByClientType() {
    var selected = $('#select_client').val();
    if (!selected || selected.length === 0) {
        window.location.href = '<?= base_url('dashboard') ?>';
        return;
    }
    window.location.href = '<?= base_url('dashboard') ?>?client_type=' + selected.join(',');
}
</script>
