<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel dm_{{ $expend }}">
        <!-- Panel Head -->
        <div class="x_title">
            <h2 class="{{ $titleColor }}">{{ $panelTitle }}<small>{{ $panelDescript }}</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li>
                    <a class="collapse-link"><i id="panelctrl" class="fa fa-chevron-down"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-search"></i></a>
                </li>
                <li>
                    <a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <!-- Panel Body -->
        <div class="x_content">
            {{ $panelContent }}
        </div>
    </div>
</div>