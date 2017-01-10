<div class="wraper">
    <div class="home_paty_container">
        <div class="home_paty_con">
            <section>
                <ul class="female_date_list outerblock" id="list-con">
                    <?php foreach($datas as $data): ?>
                    <li onclick="window.location.href = '<?= isset($data['activity'])?'/activity/view/'.$data['activity']['id']:'/date-order/join/'.$data['id']; ?>'">
                        <div class="items_date_info flex flex_justify">
                            <div class="items_left_info">
							<span class="items_left_picinfo">
								<img src="<?= isset($data['activity'])?createImg($data['activity']['big_img']):createImg($data['user']['avatar']); ?>"/>
							</span>
                                <div class="items_left_textinfo">
                                    <h3><i class="color_y"></i><?= isset($data['activity'])?$data['activity']['title']:$data['title']; ?></h3>
                                    <address class="smallarea"><i class="iconfont">&#xe623;</i> <?= isset($data['activity'])?$data['activity']['site']:$data['site']; ?></address>
                                </div>
                            </div>
                            <div class="items_right_info">
                                <span class="color_y"><i class="iconfont">&#xe622;</i><?= getMD(isset($data['activity'])?$data['activity']['start_time']:$data['start_time']); ?></span>
                                <time class="party_time"><?= getHIS(isset($data['activity'])?$data['activity']['start_time']:$data['start_time'], isset($data['activity'])?$data['activity']['end_time']:$data['end_time']); ?></time>
                                <span class="getdatebtn button <?= $data['bucls']; ?>"><?= $data['bustr']; ?></span>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </div>
    </div>
</div>