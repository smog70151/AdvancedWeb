<?php
    while($data = $result->fetch_assoc()){
?>
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail">
                            <div class="post-id" id="<?php echo $data["id"]; ?>">
                            <a href="<?php echo "http://140.114.212.79/AdvancedWeb-AS4/src/video.php?v=" . $data["vid"]?>">
                                <img src="https://i.ytimg.com/vi/<?php echo $data["vid"]?>/hqdefault.jpg" style="width:100%">
                            </a>
                            <div class="caption">
                                <a data-toggle="tooltip" title="<?php echo $data["title"]?>"><?php echo $data["title"]?></a>
                                <div class="pull-left"><i class="fa fa-headphones"></i>5335</div>
                                <div class="clearfix"></div>
                                <div class="thum-tags"><button type="button" class="btn btn-success btn-xs">初級</button></div>
                                <div class="like"><div class="text">
                                    <i class="fa fa-heart">我喜歡</i>
                                </div></div>
                            </div>
                        </div>
                    </div>
</div>
<?php
    }
?>
