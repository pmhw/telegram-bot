/**
 * 作者：qq32579135
 * 开发时间：2020年10月份
 * 开发周期：一个月
 * **/
(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
	typeof define === 'function' && define.amd ? define(factory) :
	(window.slideVerifyPlug = factory());
}(this, (function () { 'use strict';
    
    var SlideVerify = function (ele,opt) {
        this.$ele = $(ele);
        //默认参数
        this.defaults = {
            wrapWidth:'350',
            initText:'请按住滑块，拖动到最右边',
            sucessText:'验证通过',
            getSucessState:function(){
            	
            }
        }

        this.settings = $.extend({}, this.defaults, opt);
        this.touchX = 0 ;
        this.slideFinishState = false;
        this.init();
    }
    SlideVerify.prototype = {
    	constructor: SlideVerify,
        init:function () {
            var _this = this;
            _this.initDom();
            _this.initStyle();
            _this.initEle();
            _this._mousedown();
            _this._mouseup();
            _this._touchstart();
            _this._touchmove();
            _this._touchend();
        },
        initDom:function(){
        	var html = $(
        		'<div class="drag-progress dragProgress">' + 
					
				'</div>' + 
				'<span class="drag-btn dragBtn">' + 
					
				'</span>' + 
				'<span class="fix-tips fixTips">' + 
					this.settings.initText + 
				'</span>' + 
				'<span class="verify-msg sucMsg">' + 
					this.settings.sucessText + 
				'</span>');
			this.$ele.append(html);
        },
        initStyle:function(){
        	this.$ele.css({
        		'width':this.settings.wrapWidth
        	})
        },
        initEle:function(){
        	this.slideBtn = this.$ele.find('.dragBtn');
	        this.slideProEle = this.$ele.find('.dragProgress');
	        this.slideSucMsgEle = this.$ele.find('.sucMsg');
	        this.slideFixTipsEle = this.$ele.find('.fixTips');
	        this.maxSlideWid = this.calSlideWidth();
        },
        _mousedown:function(){
        	var _this = this;
        	
        	_this.slideBtn.on('mousedown',function(e){
        		var distenceX = e.pageX;
        		e.preventDefault();
        		if(_this.ifSlideRight() || _this.ifAnimated()){
					return false;
				}
        		$(document).mousemove(function(e){
					var curX = e.pageX - distenceX;
					if(curX >= _this.maxSlideWid){
						_this.setDragBtnSty(_this.maxSlideWid);
						_this.setDragProgressSty(_this.maxSlideWid);
						_this.cancelMouseMove();
						_this.slideFinishState = true;
//				    	$("#verify-msg").text('验证通过');
						if(_this.settings.getSucessState){
		                    _this.settings.getSucessState(_this.slideFinishState);
		                }
						_this.successSty();
					}else if(curX <= 0){
						_this.setDragBtnSty('0');
						_this.setDragProgressSty('0');
					}else{
						_this.setDragBtnSty(curX);
						_this.setDragProgressSty(curX);
					}
				})
				$(document).mouseup(function(){
			      	_this.cancelMouseMove();
			   });
        	})
        	
        },
        _mouseup:function(){
        	var _this = this;
        	$(document).on('mouseup',function(){
        		if(_this.ifSlideRight()){
					_this.cancelMouseMove();
					return false;
				}else{
					_this.failAnimate();
				}
        	})
        },
        _touchstart:function(){
        	var _this = this;
        	_this.slideBtn.on('touchstart',function(e){
        		_this.touchX = e.originalEvent.targetTouches[0].pageX;
				if(_this.ifSlideRight() || _this.ifAnimated()){
//					_this.cancelTouchmove();
					return false;
				}
        	})
        },
        _touchmove:function(){
        	var _this = this;
        	_this.slideBtn.on('touchmove',function(e){
        		e.preventDefault();
        		var curX = e.originalEvent.targetTouches[0].pageX - _this.touchX;
        		if(curX >= _this.maxSlideWid){
					_this.setDragBtnSty(_this.maxSlideWid);
					_this.setDragProgressSty(_this.maxSlideWid);
					_this.cancelTouchmove();
					_this.successSty();
					_this.slideFinishState = true;
					if(_this.settings.getSucessState){
	                    _this.settings.getSucessState(_this.slideFinishState);
	                }
					_this.slideFinishState = true;
				}else if(curX <= 0){
					_this.setDragBtnSty('0');
					_this.setDragProgressSty('0');
				}else{
					_this.setDragBtnSty(curX);
					_this.setDragProgressSty(curX);
				}
        	})
        },
        _touchend:function(){
        	var _this = this;
        	_this.slideBtn.on('touchend',function(){
        		if(_this.ifSlideRight()){
					_this.cancelTouchmove();
					return false;
				}else{
					_this.failAnimate();
				}
        	})
        },
        getDragBtnWid:function(){//获取滑块的宽度，
        	return parseFloat(this.slideBtn.outerWidth());
        },
        getDragWrapWid:function(){//获取  本容器的的宽度，以防万一
        	return parseFloat(this.$ele.outerWidth());
        },
        calSlideWidth:function(){
        	var _this = this;
        	return _this.getDragWrapWid() - _this.getDragBtnWid()
        },
        ifAnimated:function(){//判断 是否动画状态
        	return this.slideBtn.is(":animated")
        },
        getDragBtnLeft:function(){ //判断当前 按钮 离左侧的距离
        	return parseInt(this.slideBtn.css('left'));
        },
        ifSlideRight:function(){
        	var _this = this;
        	if(_this.getDragBtnLeft() == _this.calSlideWidth()){
        		return true;
        	}else{
        		return false;
        	}
        },
        setDragBtnSty:function(left){
        	this.slideBtn.css({
				'left':left
			})
        },
        setDragProgressSty:function(wid){
        	this.slideProEle.css({
				'width':wid
			})
        },
        cancelMouseMove:function(){
        	$(document).off('mousemove');
        },
        cancelTouchmove:function(){
        	this.slideBtn.off('touchmove');
        },
        successSty:function(){
        	this.slideSucMsgEle.show();
			this.slideBtn.addClass('suc-drag-btn');
        },
        failAnimate:function(){
        	this.slideBtn.animate({
				'left':'-1px'
			},200);
			this.slideProEle.animate({
				'width':0
			},200)
       },
       resetVerify:function(){
       		this.slideSucMsgEle.hide();
			this.slideBtn.removeClass('suc-drag-btn');
			this.slideFinishState = false;
			this.slideProEle.css({
				'width':0
			});
			this.slideBtn.css({
				'left':'-1px'
			})
			this._touchmove();
       },
    }
    var inlineCss = '*{margin:0;padding:0;box-sizing:border-box}.verify-wrap{width:350px;height:40px;background-color:#e5e5e5;border:1px solid #e0e0e0;margin:5px auto;position:relative}.verify-wrap .drag-btn{position:absolute;left:-1px;top:-1px;width:50px;height:40px;background:#fff url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACoAAAAiCAYAAAApkEs2AAAA/UlEQVRYhe3XLc9GYBjG8eN6dkdFIQuqoCiCbj6ob2CCIplRaJKqEHT3c/kAz66Xc/fLnvO3UY7N/jNmxDAMF77AQ57iOH53x5/GccTPuyNUcSg1DqXGodQ4lNr/CC3LEsuyaG8mrEKzLEPXdZjnWWszYRXq+z7yPMc0Tej7XnkzYf2Muq6LoiiwrivatsV1XUrby0Mlx3Huu7fvO5qmUd50kL31QgijTdXD+gq/zvNEVVXwPA9pmipvOqxDj+O4Q4IgQJIkypsuq9Bt21DXNaIoug/VzYRVqHw55J0Kw1BrMyHkXyj/3BHiUGocSo1DqXEota8Jvb/18hP16Z7qL3h/w53n4AAAAABJRU5ErkJggg==) no-repeat center center;background-size:100% 100%;z-index:2;cursor:move;}.verify-wrap .suc-drag-btn{background:#fff url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACoAAAAiCAYAAAApkEs2AAACA0lEQVRYhe2Y2yuDYRzHv7PJYc5zKspYSRMymStXu5NCs5W4csEfwJ+gSA53csg1F4R/gSu0OcWSmNIQkfMcEvu9tdpY79793leo91Nbbft993x6nj2/52kal8v1gX+Ajp4sFstve4jidrsR99sSUlFFlUYVVRpVVGl0SnyJ934VaxczOLpdwd3bufBeWnw+StLrYc1tQ3FqnewxZIk+vz9g7rAHO9dL3z67efXBfTkrPCqymtBqGkaiNoU9FnvpSXJyzx5R8itUQ7WU4cIWnT/qhe9xS3I91VKGC0uUfpPbV4uSajUhQ1CGshxYorRxpGDObECf1Ysm40DM2a+wNhPt7mhUZzvhMI1Aq9HBkFgUUzYSrBkNtiDCkGBES/Eg8pLKwiSdplFB8uRhEzMH3RGzsSC7j9oKe1CT4wi0oEZMeRzITy4XJOM0WkFy2uOE//1O7jA8UWrm1CeJ5dMxlGXYoI/PQrd5AQlavagkZTmwlt4UOHGCnPs9wkw+vl0jSZcWdSZDsz8uas1tD3t99rSL8b0W3Lz4cHy/LrrctYEjlQNr6Y2ptag0NIf10gv/Pvo3akRzlOGe++yTyV4yhAJ9leR6qqUMF7YoXTC6zPPChSMaVEO1ci4lstoTDdxROhE4Fjv/9jUvCIkoISPGv7nhq6JKo4oqjSqqNEIfpf8f/zqf+36643RPeo8AAAAASUVORK5CYII=) no-repeat center center;background-size:100% 100%}.verify-wrap .drag-progress{position:absolute;left:0;top:-1px;height:40px;border-top:1px solid #7ac23c;border-top:1px solid #7ac23c;width:0;background-color:#7ac23c;color:#fff;font-size:18px;text-align:center;line-height:40px}.verify-wrap .fix-tips,.verify-msg{width:100%;position:absolute;right:0;left:1px;height:100%;color:#51555c;z-index:1;line-height:38px;font-size:12px;text-align:center}.verify-wrap .verify-msg{background-color:#7ac23c;color:#fff;display:none}';
	var styleObj = $(
		'<style type="text/css">'+ inlineCss +'</style>'
	)
	$('head').prepend(styleObj);

	var slideVerify = window.slideVerifyPlug || SlideVerify;

	return slideVerify;

})));