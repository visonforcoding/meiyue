<head>
    <style>
        th{
            background-color: #cccccc;
            text-align: center;
            padding: 4px;
        }
        td{
            text-align: center;
            padding: 4px;
        }
        .horizone-title{
            background-color: #cccccc;
            width: 120px;
            font-weight: bold;
        }
        .avatar {
            height: 100px;
            width: 100px;
            padding: 0px;
        }
        .baseimg {
            height: 150px;
            padding: 0px;
        }
        .basevd {
            height: 250px;
            padding: 0px;
        }
        .idcimg {
            height: 250px;
            padding: 0px;
        }
    </style>
</head>
<body>
<div class="user view large-9 medium-8 columns content">
    
    <table border="1px" align="center"width="90%">  
        <caption><h1>基本信息</h1></caption>  
        <tbody>
            <tr>
                <th>编号</th>
                <th >昵称</th>
                <th>真实姓名</th>
                <th>手机号码</th>
                <th>年龄</th>
                <th>所在地区</th>
                <th>微信号</th>
                <th>魅力值</th>
                <th>赞赏数</th>
                <th>粉丝数</th>
                <th>最后登录时间</th>
                <th class="avatar" rowspan="4"><img src="<?= generateImgUrl(h($user->avatar)); ?>"></th>
            </tr>
            <tr>
                <td><?= h($user->id); ?></td>
                <td><?= h($user->nick); ?></td>
                <td><?= h($user->truename); ?></td>
                <td><?= h($user->phone); ?></td>
                <td><?= h(isset($user->birthday)?getAge($user->birthday):'无'); ?></td>
                <td><?= h($user->city); ?></td>
                <td><?= h($user->wxid); ?></td>
                <td><?= h(($user->charm)); ?></td>
                <td><?= h($user->fonum); ?></td>
                <td><?= h($user->fanum); ?></td>
                <td><?= h($user->login_time); ?></td>
            </tr>
            <tr>
                <th>职业</th>
                <th >家乡</th>
                <th>体重</th>
                <th>身高</th>
                <th>三围</th>
                <th>罩杯</th>
                <th>情感状态</th>
                <th>星座</th>
                <th>常出没地</th>
                <th>出生日期</th>
                <th>注册时间</th>
            </tr>
            <tr>
                <td><?= h($user->profession); ?></td>
                <td><?= h($user->hometown); ?></td>
                <td><?= h($user->weight); ?></td>
                <td><?= h($user->height); ?></td>
                <td><?= h($user->bwh); ?></td>
                <td><?= h($user->cup); ?></td>
                <td><?= h(UserState::getStatus($user->state)); ?></td>
                <td><?= h($user->zodiac); ?></td>
                <td><?= h($user->place); ?></td>
                <td><?= h($user->birthday); ?></td>
                <td><?= h($user->create_time); ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table border="1px" align="center"width="90%">  
        <tbody>
            <tr>
                <td class="horizone-title">技能</td>
                <td>
                    <?php foreach($user->user_skills as $user_skill): ?>
                        [<?= $user_skill->skill->name; ?>]
                    <?php endforeach; ?>
                </td>
                <td class="horizone-title">标签</td>
                <td>
                    <?php foreach($user->tags as $tag): ?>
                        [<?= $tag->name; ?>]
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td class="horizone-title">喜欢的美食</td>
                <td><?= h($user->food); ?></td>
                <td class="horizone-title">喜欢的音乐</td>
                <td><?= h($user->music); ?></td>
            </tr>
            <tr>
                <td class="horizone-title">喜欢的电影 </td>
                <td><?= h($user->movie); ?></td>
                <td class="horizone-title">喜欢的运动/娱乐    </td>
                <td><?= h($user->sport); ?></td>
            </tr>
            <tr>
                <td class="horizone-title">个人签名</td>
                <td colspan="3"><?= h($user->sign); ?></td>
            </tr>
            <tr>
                <td class="horizone-title">工作经历</td>
                <td colspan="3"><?= h($user->career); ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table border="1px" align="center"width="90%">  
        <caption><h1>基本照片与基本视频</h1></caption>  

            <?php if (@unserialize($user->images)): ?>
                <?php foreach(unserialize($user->images) as $index => $img): ?>
                    <tr>
                        <td class="horizone-title"><?= $index; ?></td>
                        <td><img class="baseimg" src="<?= generateImgUrl(h(createImg($img))); ?>"></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td>暂无上传图片！</td>
                </tr>
            <?php endif; ?>

            <?php if($user->video): ?>
                <tr>
                    <td colspan="2"><video class="basevd" controls="controls" preload="preload" 
                               src="<?= $user->video ?>" poster="<?= $user->video_cover ?>">
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="2">暂无上传视频！</td>
                </tr>
            <?php endif; ?>

    </table>
    <table border="1px" align="center"width="90%">  
        <caption><h1>真人视频认证</h1></caption>  


            <?php if($user->auth_video): ?>
                <tr>
                    <td colspan="2">
                        <video class="basevd" controls="controls" preload="preload" 
                               src="<?= $user->auth_video ?>" poster="<?= $user->auth_video_cover ?>">
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="2">暂无上传视频！</td>
                </tr>
            <?php endif; ?>

    </table>
    <br>
    <table border="1px" align="center"width="90%">  
        <caption><h1>身份证信息</h1></caption>  
        <tr>
            <th>正面照</th>
            <th>背面照</th>
            <th>手持照</th>
        </tr>
        <tr>
            <td><img class="idcimg" src="<?= generateImgUrl(h($user->idfront)); ?>"></td>
            <td><img class="idcimg" src="<?= generateImgUrl(h($user->idback)); ?>"></td>
            <td><img class="idcimg" src="<?= generateImgUrl(h($user->idperson)); ?>"></td>
        </tr>
    </table>
    <form>
        <table border="1px" align="center" width="90%">
            <caption><h1>审核</h1></caption>  
            <tr>
                <th>基本照片视频审核</th>
                <th>真人视频认证</th>
                <th>审核状态</th>
                <th>身份认证</th>
                <th>账号状态</th>
                <th>操作</th>
            </tr>
            <tr>
                <td class="horizone-title" id="vpstatus">
                    <input type="radio" <?= ($user->vp_status == UserStatus::CHECKING)?'checked="checked"':''?> name="vp_status" value="<?= UserStatus::CHECKING;?>" />待审核<br>
                    <input type="radio" <?= ($user->vp_status == UserStatus::PASS)?'checked="checked"':''?> name="vp_status" value="<?= UserStatus::PASS;?>" />审核通过<br>
                    <input type="radio" <?= ($user->vp_status == UserStatus::NOPASS)?'checked="checked"':''?> name="vp_status" value="<?= UserStatus::NOPASS;?>" />审核不通过
                </td>
                <td class="horizone-title" id="authstatus">
                    <input type="radio" <?= ($user->auth_status == UserStatus::CHECKING)?'checked="checked"':''?> name="auth_status" value="<?= UserStatus::CHECKING;?>" />待审核<br>
                    <input type="radio" <?= ($user->auth_status == UserStatus::PASS)?'checked="checked"':''?> name="auth_status" value="<?= UserStatus::PASS;?>" />审核通过<br>
                    <input type="radio" <?= ($user->auth_status == UserStatus::NOPASS)?'checked="checked"':''?> name="auth_status" value="<?= UserStatus::NOPASS;?>" />审核不通过
                </td>
                <td class="horizone-title" id="status">
                    <input type="radio" <?= ($user->status == UserStatus::CHECKING)?'checked="checked"':''?> name="status" value="<?= UserStatus::CHECKING;?>" />待审核<br>
                    <input type="radio" <?= ($user->status == UserStatus::PASS)?'checked="checked"':''?> name="status" value="<?= UserStatus::PASS;?>" />美女审核通过<br>
                    <input type="radio" <?= ($user->status == UserStatus::SHARE_PASS)?'checked="checked"':''?> name="status" value="<?= UserStatus::SHARE_PASS;?>" />非美女审核通过(不展示)<br>
                    <input type="radio" <?= ($user->status == UserStatus::NOPASS)?'checked="checked"':''?> name="status" value="<?= UserStatus::NOPASS;?>" />审核不通过
                </td>
                <td class="horizone-title" id="idstatus">
                    <input type="radio" <?= ($user->id_status == UserStatus::CHECKING)?'checked="checked"':''?> name="id_status" value="<?= UserStatus::CHECKING;?>" />待审核<br>
                    <input type="radio" <?= ($user->id_status == UserStatus::PASS)?'checked="checked"':''?> name="id_status" value="<?= UserStatus::PASS;?>" />审核通过<br>
                    <input type="radio" <?= ($user->id_status == UserStatus::NOPASS)?'checked="checked"':''?> name="id_status" value="<?= UserStatus::NOPASS;?>" />审核不通过
                </td>
                <td class="horizone-title">
                    <input type="radio" <?= ($user->enabled == 1)?'checked="checked"':''?> name="enabled" value="1" />正常<br>
                    <input type="radio" <?= ($user->enabled == 0)?'checked="checked"':''?> name="enabled" value="0" />禁用<br>
                </td>
                <td class="horizone-title" >
                    <button type='button' onclick="submitdata();">确定</button>
                    <button type='button' onclick="window.location.href='/user/female-index'">返回</button>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>

<script>
    function submitdata() {
        var vpstatus = $('#vpstatus input[name="vp_status"]:checked').val();
        var authstatus = $('#authstatus input[name="auth_status"]:checked').val();
        var status = $('#status input[name="status"]:checked').val();
        var idstatus = $('#idstatus input[name="id_status"]:checked').val();
        if(!vpstatus || vpstatus == 1) {
            layer.alert('基本视频图片未审核！');
            return;
        }
        if(!authstatus || authstatus == 1) {
            layer.alert('真人视频认证未审核！');
            return;
        }
        if(!status || status == 1) {
            layer.alert('审核状态未选择！');
            return;
        }
        if(!idstatus || idstatus == 1) {
            layer.alert('身份认证未审核！');
            return;
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/user/check/<?= $user->id; ?>',
            data: $('form').serialize(),
            success: function (res) {
                layer.alert(res.msg);
            }
        });
    }
</script>