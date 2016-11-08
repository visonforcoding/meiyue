$.util = {
    //返回id查找原素，没有找到时，防止为空，会构造一个
    id: function (str) {
        return document.getElementById(str) || document.createElement('span');
    },
    getParam: function (e, t) {  //获取url参数
        var n = arguments[1] || window.location.search, r = new RegExp("(^|&)" + e + "=([^&]*)(&|$)", "i"), i = n.substr(n.indexOf("?") + 1).match(r);
        return i != null ? i[2] : "";
    },
    //
    alert: function (str, t) {
        $('.alert').remove();
        document.body.append('<div class="alert"><span>'+str+'</span></div>');
        setTimeout(function () {
            $('.alert').hide();
        }, t || 3000);
    },
    showPreloader: function (str) {
        $.util.hidePreloader();
        var div = document.createElement('div');
        div.className = 'loader';
        var divInner = document.createElement('div');
        divInner.className = 'loader-inner';
        div.appendChild(divInner);
        if(str){
            div.style.cssText = 'width:120px;height:70px';
            var divTitle = document.createElement('div');
            divTitle.className = 'loader-title';
            divTitle.innerHTML = str;
            divInner.appendChild(divTitle);
        }
        document.body.appendChild(div);
        var divText = document.createElement('div');
        divText.className = 'loader-text';
        divInner.appendChild(divText);
    },
    hidePreloader:function(){
        $('.loader').remove();
    },
    /**
     * 模板处理
     * @param json
     * @param tpl
     * @returns {XML|string|*|void}
     */
    jsonToTpl: function (json, tpl) {
        return tpl.replace(/{#(\w+)#}/g, function (a, b) {
            return json[b] === 0 ? '0' : (json[b] || '');
        });
    },
    /**
     * 批量处理json列表数据
     * @param contentId string   容器id , 传入空字符串‘’的话，会返回组装好的html
     * @param tplId string 模板id
     * @param data json数据列表  array
     * @param func  处理json数据的方法，可选 会传入当前json对象
     * @returns {string}
     */
    dataToTpl: function (contentId, tplId, data, func) {
        if (!data.length)
            return '';
        var html = [], tpl = $.util.id(tplId).text;
        $.each(data, function (i, d) {
            if (func)
                d = func(d);
            html.push($.util.jsonToTpl(d, $.util.id(tplId).text));
        });
        if (contentId)
            $('#' + contentId).html(html.join(''));
        return html.join('');
    },
    /**
     * 去掉字符串两端空格
     * @param str
     */
    trim: function (str) {
        return str.replace(/(^\s*)|(\s*$)/g, "");
    },
    /**
     * 封装ajax
     * @param {type} obj
     * @returns {undefined}
     */
    ajax: function (obj) {
        var tmp = obj.func;
        if (!obj['url']) {
            obj['url'] = '';
        }
        if (!obj['dataType']) {
            obj['dataType'] = 'json';
        }
        if (!obj['type']) {
            obj['type'] = 'post';
        }
        obj.success = function (json) {
            if (json.code == 200) {
                tmp(json);
            }
            if (json.code == 403) {
                $.util.alert('请先登录');
                setTimeout(function () {
                    window.location.href = json.redirect_url;
                }, 1000);
            }
            if (json.code == 500) {
                var msg = Bollean(json['message']) ? json['message'] : json.msg;
                $.util.alert(msg);
            }
        };
        obj.statusCode = {
            404: function () {
                $.util.alert('请求页面不存在');
            },
            500: function () {
                $.util.alert('服务器繁忙');
            }
        };
        obj.error = function (XMLHttpRequest, textStatus, errorThrown) {
            $.util.alert('服务器繁忙');
            console.log(errorThrown);
        };
        $.ajax(obj);
    },
    //循环轮播
    loop: function (opt) {
        return new scroll(opt);
    },
    //轮播图  传入的都是
    loopImg: function (fatherDom, child, tab, dom) {
        return $.util.loop({
            tp: 'img', //图片img或是文字text
            //min : 5,
            loadImg: true,
            moveDom: fatherDom, // eg: $('#loopImgUl')
            moveChild: child, //$('#loopImgUl li')
            tab: tab, //$('#loopImgBar li')
            loopScroll: this.loopImg.length > 1,
            autoTime: 5000,
            lockScrY: true,
            imgInitLazy: 1000,
            //loopScroll:true,
            step: dom.width(),
            //enableTransX:true,
            index: 1,
            viewDom: dom,
            fun: function (index) {
            }
        });
    },
    /**
     * 读取COOKIE
     */
    getCookie: function (name) {
        var reg = new RegExp("(^| )" + name + "(?:=([^;]*))?(;|$)"), val = document.cookie.match(reg);
        return val ? (val[2] ? unescape(val[2]).replace(/(^")|("$)/g, "") : "") : null;
    },
    /**
     * 写入COOKIES
     */
    setCookie: function (name, value, expires, path, domain, secure) {
        var exp = new Date(), expires = arguments[2] || null, path = arguments[3] || "/", domain = arguments[4] || null, secure = arguments[5] || false;
        expires ? exp.setMinutes(exp.getMinutes() + parseInt(expires)) : "";
        document.cookie = name + '=' + escape(value) + (expires ? ';expires=' + exp.toGMTString() : '') + (path ? ';path=' + path : '') + (domain ? ';domain=' + domain : '') + (secure ? ';secure' : '');
    },
    loginWX: function (cb) {
        if (window.__isAPP) {
            LEMON.login.wx(cb);
        }
        else if ($.util.isWX) {
            location.href = '/wx/get-user-jump';
        }
    },
    /**
     * @param id  容器dom id
     */
    showLoading: function (id) {
        $('#' + id).html('<div class="loading"></div>');
    },
    /**
     * @param id  容器dom id
     */
    hideLoading: function (id) {
        $('#' + id).html('');
    },
    //初始化滚动加载列表图
    initLoadImg: function (listId) {
        var data = {cache: []}, img = $("#" + listId + " img");
        img.each(function (i) {
            var dom = $(this), init_src = dom.attr('init_src');
            init_src && data.cache.push({
                url: init_src,
                dom: dom
            });
        });
        data.num = data.cache.length;
        data.viewHeight = $(window).height();
        data.scrollOffsetH = 500;
        window._images_data = data;
        $.util.loadImg();
    },
    //滚动加载列表图
    loadImg: function (tp) {
        // 滚动条的高度
        var scrollHeight = document.body.scrollTop, d = window._images_data;
        if (!d || d.num == 0) {
            return;
        }
        // 已经卷起的高度+可视区域高度+偏移量，即当前显示的元素的高度
        visibleHeight = d.viewHeight + scrollHeight + d.scrollOffsetH;
        $.each(d.cache, function (i, data) {
            var em = data.dom, imgH = em.offset().top;
            // 图片在后面两屏范围内，并且未被加载过
            //if(tp=='detPC')$('#commDesc').append(['^'+visibleHeight, imgH].join('-'));
            if (visibleHeight > imgH && !em.attr("loaded")) {
                // 加载图片
                //em.attr('h', [d.viewHeight , scrollHeight , d.scrollOffsetH, visibleHeight, imgH].join(','))
                data.url && em.attr("src", data.url);
                em.removeAttr('init_src');
                em.attr("loaded", d.num + 1);
                d.num--;
            }
        });
    },
    //滚动事件
    listScroll: function (listId, loadFunc) {
        if (window.holdLoad)
            return;
        window.holdLoad = true;
        //setTimeout(function(){window.holdLoad = false;}, 1000);  //只允许1秒加载一次下一页   防止上一个滑动事件还没有结束的状态中

        var obj = this, st = document.body.scrollTop;

        //console.log([$(document).height(), $(window).height(),$(document).height()-$(window).height()-200,st].join('-'));
//        if (loadFunc && st >= (($(document).height() - $(window).height()) - 300)) {
        if (loadFunc && st >= (($(document).height() - 150))) {
            loadFunc();
            $.util.initLoadImg(listId);
        }
        else {
            window.holdLoad = false;
        }
        $.util.loadImg();
    },

    wxUploadPic: function (func) {
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['compressed'], // ['original', 'compressed'] 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                wx.uploadImage({
                    localId: localIds[0], // 需要上传的图片的本地ID，由chooseImage接口获得
                    isShowProgressTips: 1, // 默认为1，显示进度提示
                    success: function (res) {
                        var serverId = res.serverId; // 返回图片的服务器端ID
                        func && func(serverId);
                    }
                });
            }
        });
    },
    isLogin: function () {
        return !!$.util.getCookie('login_status');
    },
    staticLogin: function () {
        //if($.util.isAPP){
        var ifr = document.createElement('iframe');
        ifr.style.display = 'none';
        ifr.src = '/user/login_status';
        document.body.appendChild(ifr);
        //}
    },
    isMobile: function (str) {
        var reg = /^0?1[3|4|5|7|8][0-9]\d{8}$/;
        return reg.test(str);
    },
    /**
     * obj jq对象(最好不要写body,不要跟轮播的地方重合了,或是跟其他使用touch的地方重合)
     * func是要处理的方法, 防止点透可以return false;
     * tp默认norm  一般选默认
     */
    tap: function (obj, func, tp) {
        var limit = 0, max = 8, //移动超出max像素忽略本次事件
                range, p, ranges = {norm: [50, 1000], solw: [200, 1000]};

        tp = tp ? tp : 'norm';
        range = ranges[tp];
        obj.on('touchstart', function (e) {
            limit = (new Date()).getTime();
            p = $.util.getPosition(e);
        });
        obj.on('touchend', function (e) {
            var p2 = $.util.getPosition(e), x = Math.abs(p2.x - p.x), y = Math.abs(p2.y - p.y);
            if (x > max || y > max)
                return;

            limit = (new Date()).getTime() - limit;
            if (limit > range[0] && limit < range[1]) {
                return func(e);
            }
        });
    },
    /**
     * type == 'zp'的时候使用zepto的tap  否则用util的tap
     */
    onbody: function (func, type) {
        var tapfun = function(e){
            var target = e.srcElement || e.target, em = target, i = 1;
            while (em && !em.id && i <= 3) {
                em = em.parentNode;
                i++;
            }
            if (!em || !em.id)  return;
            return func(em, target);
        };
        type == 'zp' ? $('body').on('tap', tapfun) : $.util.tap($('body'), tapfun);
    },
    getPosition: function (e) {
        var touch = e.changedTouches ? e.changedTouches[0] : e;
        return {
            x: touch.pageX,
            y: touch.pageY
        };
    },
    viewImg: function (csrc, imgs) {
        if ($.util.isWX) {
            if (window.WeixinJSBridge) {
                WeixinJSBridge.invoke('imagePreview', {
                    'current': csrc,
                    'urls': imgs}
                );
            }
        }
        else if ($.util.isAPP) {
            LEMON.event.viewImg(csrc, imgs);
        }
    },
    report: function (ptag) {
        var act = 'v', param = ['/admin/report/logger?',
            'screen=' + window.screen.height + '*' + window.screen.width,
            //'refer=' + (document.referrer||document.domain).replace(/http:\/\/|https:\/\//, '').replace(/\/.*|\?.*/, '')
            'refer=' + encodeURI(document.referrer || document.domain)
        ];
        if (ptag) {
            act = 'c';
            param.push('ptag=' + ptag);
        }
        else if ($.util.getParam('ptag')) {
            param.push('ptag=' + $.util.getParam('ptag'));
        }
        param.push('act=' + act);
        (new Image).src = param.join('&');
    },
    checkUserinfoStatus: function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "/home/get-userinfo-status",
            success: function (res) {
                if (res.status) {
                    $('#shadow').hide();
                    $('#checkBtn').hide();
                } else {
                    $('#shadow').show();
                    $('#checkBtn').show();
                    $('#no, #yes, #shadow').on('click', function () {
                        setTimeout(function () {
                            $('#shadow').hide();
                            $('#checkBtn').hide();
                        }, 301);
                    });
                }
            }
        });
    },
    /**
     * 检查登录态
     * @param string url 如果已登录，跳转的页面
     */
    checkLogin: function (url) {
        if ($.util.isLogin()) {
            location.href = url;
        } else {
            $.util.alert('请登录后再操作', 1000);
            setTimeout(function () {
                location.href = '/user/login?redirect_url=' + encodeURI(document.URL);
            }, 1000);
        }
    },
    /**
     * 单文件上传预览
     * @param {string} inputId  上传input id
     * @param {string} showId   显示图片的控件 id
     * @param {function} func   回掉方法
     * @author caowenpeng
     * @returns {undefined}
     */
    singleImgPreView: function (inputId, showId,func) {
        var fileinput = document.getElementById(inputId);
        fileinput.addEventListener("change", function (e) {
            var files = this.files;
            var file = files[0];
            // image.classList.add("")
            var image = document.getElementById(showId);
            image.file = file;
            var reader = new FileReader();
            reader.onload = (function (aImg) {
                return function (e) {
                    aImg.src = e.target.result;
                };
            }(image));
            var ret = reader.readAsDataURL(file);
            var canvas = document.createElement("canvas");
            ctx = canvas.getContext("2d");
            image.onload = function () {
                ctx.drawImage(image, 100, 100);
            };
            func(inputId);
        }, false);
    },
    /**
     * zepto ajax 不能将formdata 对象成功提交故重新封装了原生xmlRequest
     * @param {string} url 请求路径
     * @param {string} type 请求类型
     * @param {object} data 数据
     * @param {function} func   回调函数 接收json返回
     * @returns {undefined}
     */
    zajax: function (url, type, data, func) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                func(JSON.parse(xhr.responseText));
            }
        };
        xhr.open(type, url, true);
        xhr.send(data);
    },
    choosImgs: function (id){
        var max=9, dom = $('#'+id); dom.data('max', max);
        //dom.on('click', function(e){
        $.util.tap(dom, function(e){
            var target = e.srcElement || e.target, em = target, i = 1;
            if(em.nodeName == 'IMG') em = em.parentNode;
            if(em.nodeName == 'DT') em = em.parentNode;
            if(em.nodeName != 'DL') return;
            var cid = $(em).data('id');
            if(cid == 'up'){
                if(dom.data('max') == 0) return;
                LEMON.event.choosePic({'key':id, 'max':dom.data('max')}, function (res) {
                    res = JSON.parse(res);
                    var cdom = $('#'+res.key), len = max-cdom.data('max'), up=cdom.find("[data-id=up]");

                    if(res.hasOwnProperty('index')){
                        cdom.find('img').eq(res.index).attr('src', 'http://image.com/'+res.key+'/'+res.index);
                        return;
                    }

                    if(res.count){
                        for(var i=0; i<res.count; i++) {
                            var src = $.util.isIOS ? 'src="http://image.com/'+res.key+'/'+(len+i)+'"' : '';
                            up.before('<dl class="Idcard" data-id="'+(len+i)+'"><dt><img '+src+'/></dt></dl>');
                        }
                    }

                    len = cdom.find('dl').length-1;
                    cdom.data('max', max-len);
                    if(len == max) up.hide();
                })
            }
            else if(cid >= 0 && cid < max){
                LEMON.event.changePic({'key':id, 'index':cid},function(res){
                    res = JSON.parse(res);
                    var cdom = $('#'+res.key);
                    cdom.find('img').eq(res.index).attr('src', 'http://image.com/'+(new Date()).getTime()+'/'+res.key+'/'+res.index);
                })

            }
        });
    },
    chooseVideo: function(id){
        var dom = $('#'+id);
        dom.on('tap', function () {
            var fun = dom.data('choosed') ? LEMON.event.changeVideo : LEMON.event.chooseVideo;
            fun({'key':id},function(res){
                res = JSON.parse(res);
                dom.find('img').eq(0).attr('src','http://video.com/'+(new Date()).getTime()+'/'+res['key']);
            });
        })
    }
};

$.util.isWX = navigator.userAgent.toLowerCase().indexOf('micromessenger') != -1;
$.util.isQQ = navigator.userAgent.toLowerCase().indexOf('qq') != -1;
$.util.isAPP = navigator.userAgent.toLowerCase().indexOf('smartlemon') != -1;
$.util.isIOS = !!$.os.ios;
$.util.isAndroid = !!$.os.android;