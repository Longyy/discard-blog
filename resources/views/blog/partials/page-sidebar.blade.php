<div class="section social">
    <a target="_blank" title="" rel="external nofollow" href="http://t.qq.com/longyy2012" data-original-title="腾讯微博">
        <i class="tencentweibo fa fa-tencent-weibo"></i>
    </a>
    <a target="_blank" title="" rel="external nofollow" href="mailto:786603430@qq.com" data-original-title="Email">
        <i class="email fa fa-envelope-o"></i>
    </a>
    <a title="" target="_blank" rel="external nofollow" href="feed" data-original-title="订阅本站">
        <i class="rss fa fa-rss"></i>
    </a>
</div>

<div class="section">
    <div class="title">
        <h2>最近文章</h2>
    </div>
    <ul class="list-unstyled list">
        @foreach ($aLatestPost as $aPost)
            <li><a href="{{ $aPost->url() }}">{{ msubstr($aPost->title) }}...</a></li>
        @endforeach
    </ul>

</div>

<div class="section">
    <div class="title">
        <h2>分类目录</h2>
    </div>
</div>

<div class="section">
    <div class="title">
        <h2>标签云</h2>
    </div>
</div>