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
                <th>赞赏数</th>
                <th>土豪榜排行</th>
                <th>消费总额</th>
                <th>会员类型</th>
                <th class="avatar" rowspan="4"><img src="/mobile/images/avatar.jpg"></th>
            </tr>
            <tr>
                <td><?= h($user->id); ?></td>
                <td><?= h($user->nick); ?></td>
                <td><?= h($user->truename); ?></td>
                <td><?= h($user->phone); ?></td>
                <td><?= h(isset($user->birthday)?getAge($user->birthday):'无'); ?></td>
                <td><?= h($user->city); ?></td>
                <td><?= h($user->wxid); ?></td>
                <td><?= h($user->fanum); ?></td>
                <td><?= h($user->paihang); ?></td>
                <td><?= h($user->recharge); ?></td>
                <td><?= h($user->viptype); ?></td>
            </tr>
            <tr>
                <th>职业</th>
                <th >家乡</th>
                <th>体重</th>
                <th>身高</th>
                <th>三围</th>
                <th>情感状态</th>
                <th>星座</th>
                <th>常出没地</th>
                <th>出生日期</th>
                <th>注册时间</th>
                <th>最后登录时间</th>
            </tr>
            <tr>
                <td><?= h($user->profession); ?></td>
                <td><?= h($user->hometown); ?></td>
                <td><?= h($user->weight); ?></td>
                <td><?= h($user->height); ?></td>
                <td><?= h($user->bwh); ?></td>
                <td><?= h(UserState::getStatus($user->state)); ?></td>
                <td><?= h(Zodiac::getStr($user->zodiac)); ?></td>
                <td><?= h($user->place); ?></td>
                <td><?= h($user->birthday); ?></td>
                <td><?= h($user->create_time); ?></td>
                <td><?= h($user->login_time); ?></td>
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
        <caption><h1>身份证信息</h1></caption>  
        <tr>
            <th>正面照</th>
            <th>背面照</th>
            <th>手持照</th>
        </tr>
        <tr>
            <td><img class="idcimg" src="<?= h($user->idfront); ?>"></td>
            <td><img class="idcimg" src="<?= h($user->idback); ?>"></td>
            <td><img class="idcimg" src="<?= h($user->idperson); ?>"></td>
        </tr>
    </table>
    <form>
        <table border="1px" align="center" width="90%">
            <caption><h1>审核</h1></caption>  
            <tr>
                <th>审核状态</th>
                <th>身份认证</th>
                <th>账号状态</th>
                <th>操作</th>
            </tr>
            <td class="horizone-title">
                无需审核
                <input type="radio" <?= ($user->status == UserStatus::NONEED)?'checked="checked"':''?> name="status" value="<?= UserStatus::NONEED;?>" />
                待审核
                <input type="radio" <?= ($user->status == UserStatus::CHECKING)?'checked="checked"':''?> name="status" value="<?= UserStatus::CHECKING;?>" />
                审核通过
                <input type="radio" <?= ($user->status == UserStatus::PASS)?'checked="checked"':''?> name="status" value="<?= UserStatus::PASS;?>" />
                审核不通过
                <input type="radio" <?= ($user->status == UserStatus::NOPASS)?'checked="checked"':''?> name="status" value="<?= UserStatus::NOPASS;?>" />
            </td>
            <td class="horizone-title">
                待审核
                <input type="radio" <?= ($user->id_status == UserStatus::CHECKING)?'checked="checked"':''?> name="id_status" value="<?= UserStatus::CHECKING;?>" />
                审核通过
                <input type="radio" <?= ($user->id_status == UserStatus::PASS)?'checked="checked"':''?> name="id_status" value="<?= UserStatus::PASS;?>" />
                审核不通过
                <input type="radio" <?= ($user->id_status == UserStatus::NOPASS)?'checked="checked"':''?> name="id_status" value="<?= UserStatus::NOPASS;?>" />
            </td>
            <td class="horizone-title">
                正常
                <input type="radio" <?= ($user->enabled == 1)?'checked="checked"':''?> name="enabled" value="1" />
                禁用
                <input type="radio" <?= ($user->enabled == 0)?'checked="checked"':''?> name="enabled" value="0" />
            </td>
            <td class="horizone-title" >
                <button type='button' onclick="submitdata();">确定</button>
                <button type='button' onclick="window.location.href='/user/male-index'">返回</button>
            </td>
            </tr>
        </table>
    </form>
</div>
</body>

<script>
    function submitdata() {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/user/check/<?= $user->id; ?>',
            data: $('form').serialize(),
            success: function (res) {
                alert(res.msg);
            }
        });
    }
</script>