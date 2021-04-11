<script type="text/javascript">
    jQuery(document).ready(function () {
        var hash = window.location.hash.substr(1);
        jQuery('.servicestab').find('li').each(function () {
            if (jQuery(this).attr('rel') == hash)
                jQuery(this).click();
        });
    });
</script>
<style>
    .col-lg-6.col-xl-8.pnl-left {
        padding-left: 0;
    }

    .col-lg-6.col-xl-8.pnl-left {
        margin-bottom: 0;
    }
    ul.tabs.servicestab.module_custom_tab {
        display: none;
    }
    .box-header h3 {
        font-weight: 300;
        font-size: 16px;
    }
    .files-header {
        padding: 20px 0;
        background-image: linear-gradient(127deg, #888888, #888888);
    }
    .files-header h3 {
        font-weight: 300;
        font-size: 18px
    }
</style>

<div class="account-header">
    <div class="back-act"><a href="clientarea.php?action=products"><i class="fas fa-long-arrow-alt-left"></i> {$LANG.backtoaccountoverview}</a></div>
    <div class="web-url"> {$domain}</div>
    <div class="web-actv"><a href="#">{$status}</a></div>
</div>
<div class="cpanl-row row-wgs-mrgn">
    {$ResetMessage = $smarty.get.ResetMessage}
            {if $ResetMessage}
                {if $ResetMessage eq 'successfull'}
                    <div class="alert alert-success text-center">ریست هاست با موفقیت انجام شد. اطلاعات سی پنل مجدد به ایمیل شما ارسال گردید.</div>
                {elseif $ResetMessage eq 'removefailed'}
                    <div class="alert alert-danger text-center">ریست هاست با خطا مواجه شد !</div>
                {elseif $ResetMessage eq 'getplanfailed'}
                    <div class="alert alert-danger text-center">خطایی در دریافت اطلاعات پلن کاربر رخ داده است !</div>
                {elseif $ResetMessage eq 'nouserdata'}
                    <div class="alert alert-danger text-center">خطایی در بدست آوردن اطلاعات کاربر رخ داده است !</div>
                {elseif $ResetMessage eq 'nouser'}  
                    <div class="alert alert-danger text-center">کاربری با این مشخصات یافت نشد !</div>
                {elseif $ResetMessage eq 'getconfigfailed'}
                    <div class="alert alert-danger text-center">دریافت تنظیمات ماژول با خطا مواجه شد !</div>
                {/if}
            {/if}
    <ul class="tabs servicestab">
        <li class="active" rel="tabOverview">
            <a href="javascript:void(0);">
                <div class="tbs-icone"><i class="far fa-list-alt"></i></div>
                    {$LANG.overview}
            </a>
        </li>
        {if $module == 'cpanel'}
            <li class="">
                <a href="clientarea.php?action=productdetails&id={$id}&dosinglesignon=1" target="_blank">
                    <div class="tbs-icone"> <i class="far fa-user"></i></div>
                        {$LANG.cpanellogin}
                </a>
            </li>
            <li class="">
                <a href="https://{$serverdata.hostname}:2096" target="_blank">
                    <div class="tbs-icone"> <i class="far fa-user"></i></div>
                        {$LANG.cpanelwebmaillogin}
                </a>
            </li>
            
            <li id="reset_host">
                <a href="modules/addons/server_custom_configs/reset_cpanel_host.php?hostId={$id}">
                    <div class="tbs-icone"> <i class="far fa-user"></i></div>
                        ریست هاست
                </a>
            </li>
        {/if}
        {if $modulechangepassword}
            <li rel="tabChangepw" class="">
                <a href="javascript:void(0);">
                    <div class="tbs-icone"> <i class="fas fa-lock"></i></div>
                        {$LANG.serverchangepassword}
                </a>
            </li>
        {/if}
        {if $downloads}
            <li  rel="tabDownloads" class="">
                <a href="javascript:void(0);">
                    <div class="tbs-icone"> <i class="fas fa-download"></i></div>
                        {$LANG.downloadstitle}
                </a>
            </li>
        {/if}
        {if $addonsavailable}
            <li  rel="tabAddons" class="">
                <a href="javascript:void(0);">
                    <div class="tbs-icone"> <i class="fas fa-plus"></i></div>
                        {$LANG.clientareahostingaddons}
                </a>
            </li>
        {/if}
        {if $packagesupgrade}
            <li class="">
                <a href="upgrade.php?type=package&id={$id}">
                    <div class="tbs-icone"> <i class="fas fa-cloud-upload-alt"></i></div>
                        {$LANG.upgradedowngradepackage}
                </a>
            </li>
        {/if}
        {if $configoptionsupgrade}
            <li class="">
                <a href="upgrade.php?type=configoptions&amp;id={$id}">
                    <div class="tbs-icone"> <i class="fas fa-cloud-upload-alt"></i></div>
                        {$LANG.upgradedowngradeconfigoptions}
                </a>
            </li>
        {/if}

        {if $showcancelbutton}
            <li class="tab_last">
                <a href="clientarea.php?action=cancel&id={$id}">
                    <div class="tbs-icone"> <i class="fas fa-times"></i></div>
                        {$LANG.clientareacancelrequestbutton}
                </a>
            </li>
        {/if}
        {if $module == 'OpenStackVPS'}
            <li id="Openstack_Management">
                <a href="clientarea.php?action=productdetails&id={$id}&modop=custom&a=management">
                    <div class="tbs-icone"> <i class="fa fa-wrench"></i></div>
                        Management
                </a>
            </li>
            <li id="Openstack_Rebuild">
                <a href="clientarea.php?action=productdetails&id={$id}&modop=custom&a=management&act=rebuild">
                    <div class="tbs-icone"> <i class="glyphicon glyphicon-wrench"></i></div>
                        Rebuild
                </a>
            </li>
            <li id="Openstack_Firewall">
                <a href="clientarea.php?action=productdetails&id={$id}&modop=custom&a=management&act=firewall">
                    <div class="tbs-icone"> <i class="glyphicon glyphicon-folder-close"></i></div>
                        Firewall
                </a>
            </li>
            <li id="Openstack_Backups">
                <a href="clientarea.php?action=productdetails&id={$id}&modop=custom&a=management&act=backups">
                    <div class="tbs-icone"> <i class="glyphicon glyphicon-hdd"></i></div>
                        Backups
                </a>
            </li>
        {/if}
    </ul>
    {if $modulecustombuttons}
        <ul class="tabs servicestab module_custom_tab" style="margin-top: 25px;">
            {foreach from=$modulecustombuttons key=label item=command}
                <li><a href="clientarea.php?action=productdetails&amp;id={$id}&amp;modop=custom&amp;a={$command}">{$label}</a></li>
                {/foreach}
        </ul>
    {/if}
    <div class="tab_container main-content">
        {if $modulecustombuttonresult}
            {if $modulecustombuttonresult == "success"}
                {include file="$template/includes/alert.tpl" type="success" msg=$LANG.moduleactionsuccess textcenter=true idname="alertModuleCustomButtonSuccess"}
            {else}
                {include file="$template/includes/alert.tpl" type="error" msg=$LANG.moduleactionfailed|cat:' ':$modulecustombuttonresult textcenter=true idname="alertModuleCustomButtonFailed"}
            {/if}
        {/if}

        {if $pendingcancellation}
            {include file="$template/includes/alert.tpl" type="error" msg=$LANG.cancellationrequestedexplanation textcenter=true idname="alertPendingCancellation"}
        {/if}
        <div id="tabOverview" class="tab_content" style="display: block;">
            <h3 class="tab_drawer_heading d_active"><i class="far fa-list-alt"></i> {$LANG.overview}</h3>
            {if $tplOverviewTabOutput}
                {$tplOverviewTabOutput}
            {else}

                <div class="col-lg-6 col-xl-8 pnl-left">
                    <div class="box-cpanl">
                        <div class="box-header">
                            <h3>{$product}</h3>
                        </div>
                        <div class="plan-colam">
                            <div class="uno"><a href="#">{$product}</a></div>
                            <span class="host-shar"><a href="#">{$groupname}</a></span>
                            {if $domain}<div class="host-name"> <a href="http://{$domain}">{$domain}</a>{if $domainId}&nbsp; <a href="clientarea.php?action=domaindetails&id={$domainId}" class="btn btn-default" target="_blank">{$LANG.managedomain}</a>{/if}</div>{/if}
                            <div class="btn-box"> <a href="http://{$domain}" class="visit" target="_blank">{$LANG.visitwebsite}</a> <a href="#" class="visit ifo" onclick="popupWindow('whois.php?domain={$domain}', 'whois', 650, 420);return false;" >{$LANG.whoisinfo}</a></div>
                        </div>
                        {if $hookOutput}
                            <div class="col-lg-12">
                                {foreach $hookOutput as $output}
                                    <div>
                                        {$output}
                                    </div>
                                {/foreach}
                            {/if}
                        </div>
                    </div>
                </div>
                {if $lastupdate}
                    <div class="col-lg-6 col-xl-8 pnl-right">
                        <div id="resourceusage">
                            <div class="box-cpanl">
                                <div class="box-header statistic">
                                    <h3>{$LANG.resourceUsage}</h3>
                                </div>
                                <div class="plan-statistic">
                                    <div class="disk-use">
                                        <h5 class="disk-titel"> {$LANG.diskSpace}</h5>
                                        <div class="dick-mp"><input type="text" value="{$diskpercent|substr:0:-1}" class="dial-usage" data-width="100" data-height="100" data-min="0" data-readOnly="true" /></div>
                                        <span class="rpm">{$diskusage}MB / {$disklimit}MB </span> </div>
                                    <div class="disk-use">
                                        <h5 class="disk-titel"> {$LANG.bandwidth}</h5>
                                        <div class="dick-mp"><input type="text" value="{$bwpercent|substr:0:-1}" class="dial-usage" data-width="100" data-height="100" data-min="0" data-readOnly="true" /></div>
                                        <span class="rpm">{$bwusage}MB / {$bwlimit}MB </span> </div>
                                    <div class="last-upd">{$LANG.clientarealastupdated}: {$lastupdate}</div>
                                    <script src="{$BASE_PATH_JS}/jquery.knob.js"></script>
                                    <script type="text/javascript">
                                jQuery(function () {ldelim}
                                        jQuery(".dial-usage").knob({ldelim}'format': function (v) {ldelim}
                                                        alert(v);
                                        {rdelim}{rdelim});
                                        {rdelim});
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}
                {if $configurableoptions}
                    <div class="col-lg-6 col-xl-8 {if $lastupdate}pnl-left{else}pnl-right{/if}">
                        <div id="configoptions">
                            <div class="file-row">
                                <div class="box-cpanl">
                                    <div class="box-header statistic">
                                        <h3>{$LANG.orderconfigpackage}</h3>
                                    </div>
                                    <div class="files-body">
                                        {foreach from=$configurableoptions item=configoption}
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <strong>{$configoption.optionname}</strong>
                                                    </div>
                                                    <div class="col-sm-9 text-left">
                                        {if $configoption.optiontype eq 3}{if $configoption.selectedqty}{$LANG.yes}{else}{$LANG.no}{/if}{elseif $configoption.optiontype eq 4}{$configoption.selectedqty} x {$configoption.selectedoption}{else}{$configoption.selectedoption}{/if}
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
{if $customfields}
    <div class="col-lg-6 col-xl-8 pnl-right" id="">
        <div id="additionalinfo">
            <div class="file-row">
                <div class="box-cpanl">
                    <div class="box-header statistic">
                        <h3>{$LANG.additionalInfo}</h3>
                    </div>
                    <div class="files-body">
                        {foreach from=$customfields item=field}
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <strong>{$field.name}</strong>
                                    </div>
                                    <div class="col-sm-9 text-left">
                                        {$field.value}
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}

<div class="emailacc-row">
    <div class="file-row">
        <div class="box-cpanl">
            <div class="files-header">
                <h3>{if $type eq "server"}{$LANG.sslserverinfo}{elseif ($type eq "hostingaccount" || $type eq "reselleraccount") && $serverdata}{$LANG.hostingInfo}{elseif !$domain && $moduleclientarea}{$LANG.manage}{else}{$LANG.clientareahostingdomain}{/if}</h3>
            </div>
            <div class="files-body">
                {if $domain}
                    <div class="tab-pane fade in active" id="domain">
                        {if $type eq "server"}
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-3 text-left">
                                        <strong>{$LANG.serverhostname}</strong>
                                    </div>
                                    <div class="col-sm-9 text-left">
                                        {$domain}
                                    </div>
                                </div>
                            </div>
                            {if $dedicatedip}
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-3 text-left">
                                            <strong>{$LANG.primaryIP}</strong>
                                        </div>
                                        <div class="col-sm-9 text-left">
                                            {$dedicatedip}
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            {if $assignedips}
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-3 text-left">
                                            <strong>{$LANG.assignedIPs}</strong>
                                        </div>
                                        <div class="col-sm-9 text-left">
                                            {$assignedips|nl2br}
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            {if $ns1 || $ns2}
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-3 text-left">
                                            <strong>{$LANG.domainnameservers}</strong>
                                        </div>
                                        <div class="col-sm-9 text-left">
                                            {$ns1}<br />{$ns2}
                                        </div>
                                    </div>
                                </div>
                            {/if}
                        {elseif ($type eq "hostingaccount" || $type eq "reselleraccount") && $serverdata}
                            {if $domain}
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-3 text-left">
                                            <strong>{$LANG.orderdomain}</strong>
                                        </div>
                                        <div class="col-sm-9 text-left">
                                            {$domain}&nbsp;<a href="http://{$domain}" target="_blank" class="btn btn-default btn-xs" >{$LANG.visitwebsite}</a>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            {if $username}
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-3 text-left">
                                            <strong>{$LANG.serverusername}</strong>
                                        </div>
                                        <div class="col-sm-9 text-left">
                                            {$username}
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-3 text-left">
                                        <strong>{$LANG.servername}</strong>
                                    </div>
                                    <div class="col-sm-9 text-left">
                                        {$serverdata.hostname}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-sm-3 text-left">
                                        <strong>{$LANG.domainregisternsip}</strong>
                                    </div>
                                    <div class="col-sm-9 text-left">
                                        {$serverdata.ipaddress}
                                    </div>
                                </div>
                            </div>
                            {if $serverdata.nameserver1 || $serverdata.nameserver2 || $serverdata.nameserver3 || $serverdata.nameserver4 || $serverdata.nameserver5}
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-3 text-left">
                                            <strong>{$LANG.domainnameservers}</strong>
                                        </div>
                                        <div class="col-sm-9 text-left">
                                            {if $serverdata.nameserver1}{$serverdata.nameserver1} ({$serverdata.nameserver1ip})<br />{/if}
                                            {if $serverdata.nameserver2}{$serverdata.nameserver2} ({$serverdata.nameserver2ip})<br />{/if}
                                            {if $serverdata.nameserver3}{$serverdata.nameserver3} ({$serverdata.nameserver3ip})<br />{/if}
                                            {if $serverdata.nameserver4}{$serverdata.nameserver4} ({$serverdata.nameserver4ip})<br />{/if}
                                            {if $serverdata.nameserver5}{$serverdata.nameserver5} ({$serverdata.nameserver5ip})<br />{/if}
                                        </div>
                                    </div>
                                </div>
                            {/if}
                        {else}
                        {/if}
                        {if $moduleclientarea}
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="text-center module-client-area">
                                        {$moduleclientarea}
                                    </div>
                                </div>
                            </div>
                        {/if}
                    </div>
                {elseif $moduleclientarea}
                    <div class="tab-pane fade{if !$domain} in active{/if} text-center" id="manage">
                        <div class="col-lg-12">
                            <div class="text-center module-client-area">
                                {$moduleclientarea}
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
    <div class="emailacc-row">
        <div class="box-cpanl">
            <div class="email-header bill">
                <h3>{$LANG.cPanel.billingOverview}</h3>
            </div>
            <div class="billing-potal">
                <div class="col-md-5">
                    <ul class="month-price">
                        {if $firstpaymentamount neq $recurringamount}<li> <span class="amout-dt">{$LANG.firstpaymentamount} </span> <span class="pay-price">{$firstpaymentamount}</span></li>{/if}
                        {if $billingcycle != $LANG.orderpaymenttermonetime && $billingcycle != $LANG.orderfree}<li> <span class="amout-dt">{$LANG.recurringamount} </span> <span class="pay-price">{$recurringamount}</span></li>{/if}
                        <li><span class="amout-dt">{$LANG.orderbillingcycle}</span> <span class="pay-price"> {$billingcycle}</span></li>
                        <li><span class="amout-dt">{$LANG.orderpaymentmethod}</span> <span class="pay-price"> {$paymentmethod}</span></li>
                    </ul>
                </div>
                <div class="col-md-5">
                    <ul class="month-price">
                        <li> <span class="amout-dt">{$LANG.clientareahostingregdate}</span> <span class="pay-price">{$regdate}</span></li>
                        <li><span class="amout-dt">{$LANG.clientareahostingnextduedate} </span> <span class="pay-price">{$nextduedate}</span></li>
                            {if $suspendreason}
                            <li><span class="amout-dt">{$LANG.suspendreason} </span> <span class="pay-price">{$suspendreason}</span></li>
                            {/if}
                    </ul>
                </div>
            </div>
        </div>
    </div>
{/if}
</div>

<div id="tabDownloads" class="tab_content" style="display: none;">
    <h3 class="tab_drawer_heading" rel="tabDownloads"><i class="far fa-user"></i> {$LANG.downloadstitle}</h3>


    <div class="file-row">
        <div class="box-cpanl">
            <div class="files-header">
                <h3>{$LANG.downloadstitle}</h3>
            </div>
            <div class="files-body">
                <div class="">
                    {include file="$template/includes/alert.tpl" type="info" msg="{lang key="clientAreaProductDownloadsAvailable"}" textcenter=true}
                </div>
                {foreach from=$downloads item=download}
                    <div class="files-item downloads"> <a href="{$download.link}">
                            <div class="file-icone"><i class="fas fa-download"></i> </div>
                            <div class="file-link"> {$download.title} </div>
                            {if $download.description}<p>
                                    {$download.description}
                                </p>
                            {/if}
                        </a> 
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
</div>

<div id="tabChangepw" class="tab_content" style="display: none;">
    <h3 class="tab_drawer_heading"><i class="fas fa-lock"></i> Change Password</h3>

    <div class="file-row">
        <div class="box-cpanl">
            <div class="files-header">
                <h3>{$LANG.serverchangepassword}</h3>
            </div>
            <div class="files-body">
                <div class="form-colam">
                    {*                    <h2>{$LANG.serverchangepassword}</h2>*}
                    {if $modulechangepwresult}
                        {if $modulechangepwresult == "success"}
                            {include file="$template/includes/alert.tpl" type="success" msg=$modulechangepasswordmessage textcenter=true}
                        {elseif $modulechangepwresult == "error"}
                            {include file="$template/includes/alert.tpl" type="error" msg=$modulechangepasswordmessage|strip_tags textcenter=true}
                        {/if}
                    {/if}
                </div>
                <form class="form-horizontal using-password-strength" method="post" action="{$smarty.server.PHP_SELF}?action=productdetails#tabChangepw" role="form">
                    <input type="hidden" name="id" value="{$id}" />
                    <input type="hidden" name="modulechangepassword" value="true" />


                    <div class="formBox">
                        <div class="form-colam">
                            <div class="col-sm-6">
                                <div id="newPassword1" class="has-feedback">
                                    <div class="inputBox">
                                        <div class="inputText">{$LANG.newpassword} </div>
                                        <input type="password" class="input" id="inputNewPassword1" name="newpw" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="newPassword2" class="has-feedback">
                                    <div class="inputBox">
                                        <div class="inputText">{$LANG.confirmnewpassword}</div>
                                        <input type="password" class="input" id="inputNewPassword2" name="confirmpw" autocomplete="off" />
                                        <div id="inputNewPassword2Msg">
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-sm-6">
                                <div class="inputBox">
                                    {include file="$template/includes/pwstrength.tpl"}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-6 col-sm-6">
                            <input class="btn-save wgs_custom-btn" type="submit" value="{$LANG.clientareasavechanges}" />
                            <input class="btn-cancel" type="reset" value="{$LANG.cancel}" />
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>    
</div>
<div id="tabAddons" class="tab_content" style="display: none;">
    <h3 class="tab_drawer_heading" rel="tabAddons"><i class="fas fa-cloud-upload-alt"></i> {$LANG.clientareahostingaddons}</h3>

    <div class="file-row">
        <div class="box-cpanl">
            <div class="files-header">
                <h3>{$LANG.clientareahostingaddons}</h3>
            </div>
            <div class="files-body">
                <div class="form-colam">
                    {if $addonsavailable}
                        {include file="$template/includes/alert.tpl" type="info" msg="{lang key="clientAreaProductAddonsAvailable"}" textcenter=true}
                    {/if}
                </div>

                <div class="prot-dns">
                    {foreach from=$addons item=addon}
                        <div class="col-md-4">
                            <div class="increased">
                                {*                                <div class="icone-dns"><img src="images/dns-ic.png" alt="#"></div>*}
                                <h2>{$addon.name} </h2>
                                <p>
                                    {$addon.pricing}
                                </p>
                                <p>
                                    {$LANG.registered}: {$addon.regdate}
                                </p>
                                <p>
                                    {$LANG.clientareahostingnextduedate}: {$addon.nextduedate}
                                </p>
                                {if $addon.managementActions}
                                    <p>
                                        {$addon.managementActions}
                                    </p>
                                {/if}
                                <div class="checkbox icon-check">
                                    <label>
                                        <div class="pull-right status-{$addon.rawstatus|strtolower}">{$addon.status}</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>


</div>
</div>
<!-- .tab_container --> 
</div>
<script type="text/javascript">
	document.getElementById("reset_host").onclick = function(){
		if (!confirm("لطفاً توجه داشته باشید که ریست کردن هاست به معنای حذف تمام اطلاعات و به طور کلی مشابه سازی هاست مانند روز ابتدای تحویل آن به شما می باشد و کلیک بر روی گزینه ی زیر به منزله ی رضایت شما از حذف کامل اطلاعات بدون امکان بازگشت ان میباشد.لازم به ذکر است در صورتی که از خدمات  نمایندگی هاست استفاده میفرمایید با کلیک بر روی این گزینه کل هاست های موجود در نمایندگی شما حذف و مجدد ایجاد خواهند شد .")) {
			return false;
		}
	}
</script>
