<?php


use yii\helpers\Url;


/* @var $this yii\web\View */
$this->title = Yii::$app->name;
?>
<div class="main-header">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
            <h2 class="cat_name">My Records</h2>
            <em>Dashboard </em>
        </div>
    </div>
</div>
<!--/.main-header-->  
<div class="main-content">
    <div class="row">
        <div class="box-wrapper">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual"> <i class="fa fa-warning"></i> </div>
                    <div class="details">
                        <div class="number"> <?=$expired;?> </div>
                        <div class="desc"> Expired</div>
                    </div>
                    <!--<a class="more" href="javascript:void(0);"> View More<i class="m-icon-swapright m-icon-white"></i> </a>--> 
                </div>
            </div>
        </div>
        <!--/.box-wrapper-->
        <div class="box-wrapper">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense orange_clr">
                    <div class="visual"> <i class="fa fa-calendar"></i> </div>
                    <div class="details">
                        <div class="number"> <?=$today;?> due </div>
                        <div class="desc"> Today </div>
                    </div>
                    <!--<a class="more" style=" background:#D78844 !important;" href="javascript:void(0);"> View More <i class="m-icon-swapright m-icon-white"></i> </a>--> 
                </div>
            </div>
        </div>
        <!--/.box-wrapper-->
        <div class="box-wrapper">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual"> <i class="fa fa-calendar"></i> </div>
                    <div class="details">
                        <div class="number"> <?=$expire10;?> due</div>
                        <div class="desc"> In next 10 Days </div>
                    </div>
                    <!--<a class="more" href="javascript:void(0);"> View More<i class="m-icon-swapright m-icon-white"></i> </a>--> 
                </div>
            </div>
        </div>
        <!--/.box-wrapper-->
        <div class="box-wrapper">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum light_blue-clr">
                    <div class="visual"> <i class="fa fa-calendar"></i> </div>
                    <div class="details">
                        <div class="number"> <?=$expire30;?> due</div>
                        <div class="desc">In next 30 Days </div>
                    </div>
                    <!--<a class="more" href="javascript:void(0);"> View More <i class="m-icon-swapright m-icon-white"></i> </a>--> 
                </div>
            </div>
        </div>
        <!--/.box-wrapper-->
        <!--/.box-wrapper-btns--> 
    </div>
    <section class="content">
        <div class="row main-row-wrapper">
            <div class="col-md-12">
                <!--document dashboard content left starts here-->
                <div class="dashborad_content_left">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-header">
                                    <h3>
                                        <i class="fa fa-clock-o"></i> 
                                        Upcomming Expirations 
                                        <small>(upto 20 documents) </small>
                                    </h3>
                                    <em>- </em> 
                                </div>
                                <div class="widget-content document-table">
                                    <div class="table-responsive">
                                        <table width="100%" cellpadding="0" cellspacing="0" class="table table-bordered" id="documenttypes">
                                            <thead>
                                                <tr>
                                                    <th width="13%">Due Date</th>
                                                    <th width="77%">Title</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php if( isset($next20) && count($next20)){ 
                                                         foreach ($next20 as $doc_next_20) { ?>
                                                        <tr>
                                                            <td><?=date('Y-m-d', strtotime($doc_next_20->expire));?></td>
                                                            <td><?=$doc_next_20->title;?> 
                                                                <small> 
                                                                <?php /*
                                                                    <!-- <span class="doc_status" style="background: #FF0000;"> Expired </span> -->
                                                                    (<a href=""> sent 0 , 3 in que</a>)
                                                                    */ ?>
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <ul class="desktop_expiry_panel">
                                                                    <li> 
                                                                        <a href="<?=Url::to(['certificates/update', 'id' => $doc_next_20->id]);?>" data-toggle="tooltip" title="" data-original-title="Edit">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li> 
                                                                        <a href="<?=Url::to(['certificates/view', 'id' => $doc_next_20->id]);?>" data-toggle="tooltip" title="" data-original-title="View">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                    </li>
                                                                    <?php /*
                                                                        <li> <a href="#" data-toggle="tooltip" class="refresh_icon" title="" data-original-title="Renew"><i class="fa fa-refresh"></i></a></li>
                                                                        <li> <a href="#" data-toggle="tooltip" class="tash_icon" title="" data-original-title="Trash" class="ask"><i class="fa fa-trash-o"></i></a></li>
                                                                    */ ?>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-header">
                                    <h3>
                                        <strong>
                                            <i class="fa fa-clipboard fa-fw"></i> 
                                            Documetns over due
                                        </strong>
                                        <small> last 10 records </small>
                                    </h3>
                                    <em>- </em> 
                                </div>
                                <div class="widget-content document-table">
                                    <div class="table-responsive">
                                        <table width="100%" cellpadding="0" cellspacing="0" class="table table-bordered" id="documenttypes">
                                            <thead>
                                                <tr>
                                                    <th width="13%">Expiration Date</th>
                                                    <th width="77%">Title</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if( isset($last10doc) && count($last10doc) ){  
                                                        foreach ( $last10doc as $doc10 ) { ?>
                                                        <tr>
                                                            <td><?=date('Y-m-d', strtotime($doc10->expire));?></td>
                                                            <td><?=$doc10->title;?> 
                                                                <small> 
                                                                    <span class="doc_status" style="background: #FF0000;"> Expired </span>
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <ul class="desktop_expiry_panel">
                                                                    <li> 
                                                                        <a href="<?=Url::to(['certificates/update', 'id' => $doc10->id]);?>" data-toggle="tooltip" title="" data-original-title="Edit">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li> 
                                                                        <a href="<?=Url::to(['certificates/view', 'id' => $doc10->id]);?>" data-toggle="tooltip" title="" data-original-title="View">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                    </li>
                                                                    <!-- <?php /*
                                                                        <li> <a href="#" data-toggle="tooltip" class="refresh_icon" title="" data-original-title="Renew"><i class="fa fa-refresh"></i></a></li>
                                                                        <li> <a href="#" data-toggle="tooltip" class="tash_icon" title="" data-original-title="Trash" class="ask"><i class="fa fa-trash-o"></i></a></li>
                                                                    */ ?> -->
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  


                </div>
                <!--/.dashborad_content_left--> 
            </div>
            <!--document dashboard content left ends here--> 
        </div>
        <!--/.main-row-wrapper-->       
        <!--.container--> 
    </section>
</div>
<!--/.main-content--> 