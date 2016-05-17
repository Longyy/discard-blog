
<!--
<div class="container">
    <div class="row">
        <div class="col-lg-7 col-md-10">

            {{-- Navigation --}}
            <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
                    {{-- Brand and toggle get grouped for better mobile display --}}
                    <div class="navbar-header page-scroll">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target="#navbar-main">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/">{{ config('blog.name') }}</a>
                    </div>

                    {{-- Collect the nav links, forms, and other content for toggling --}}
                    <div class="collapse navbar-collapse" id="navbar-main">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="/">首页</a>
                            </li>
                            <li>
                                <a href="/">关于我</a>
                            </li>
                            <li>
                                <a href="/">博文</a>
                            </li>
                        </ul>
                    </div>
            </nav>
        </div>
        <div class="col-lg-4 col-md-2">
            <div>搜索</div>
        </div>
    </div>
</div>
-->

{{-- Navigation --}}
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10">
                {{-- Brand and toggle get grouped for better mobile display --}}
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#navbar-main">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">{{ config('blog.name') }}</a>
                </div>

                {{-- Collect the nav links, forms, and other content for toggling --}}
                <div class="collapse navbar-collapse" id="navbar-main">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/">首页</a>
                        </li>
                        <li>
                            <a href="/">关于我</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false" href="/">博文<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">艳照</a></li>
                                <li><a href="#">旅游照</a></li>
                                <li><a href="#">发牢骚</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-2">
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </form>
            </div>
        </div>

    </div>

</nav>
