(function ($, window, document) {

    'use strict';

    var defaults = {
        maxWidth: 900,
        maxHeight: 700,
        transition: 'random',
        customTransitions: [],
        fallback3d: 'fade',
        perspective: 1000,
        navigation: hugeitSliderObj.show_arrows,
        thumbMargin: .5,
        autoPlay: true,
        controls: 'dot',
        cropImage: 'stretch',
        delay: 5000,
        transitionDuration: 2000,
        pauseOnHover: true,
        startSlide: 0,
        keyNav: false
    };

    function Slider(elem, settings) {
        this.$slider = $(elem).addClass('huge-it-slider');
        this.settings = $.extend({}, defaults, settings);
        this.$slides = this.$slider.find('> li');
        this.totalSlides = this.$slides.length;
        this.cssTransitions = testBrowser.cssTransitions();
        this.cssTransforms3d = testBrowser.cssTransforms3d();
        this.currentPlace = this.settings.startSlide;
        this.$currentSlide = this.$slides.eq(this.currentPlace);
        this.inProgress = false;
        this.$sliderWrap = this.$slider.wrap('<div class="huge-it-wrap" />').parent();
        this.$sliderBG = this.$slider.wrap('<div class="huge-it-slide-bg" />').parent();
        this.settings.slider = this;

        this.init();
    }

    Slider.prototype.cycling = null;

    Slider.prototype.$slideImages = null;

    Slider.prototype.init = function () {

        var _this = this;

        this.captions();

        (this.settings.transition === 'custom') && (this.nextAnimIndex = -1);

        +this.settings.navigation && this.setArrows();


        this.settings.keyNav && this.setKeys();

        for (var i = 0; i < this.totalSlides; i++) {
            this.$slides.eq(i).addClass('huge-it-slide-' + i);
        }

        this.settings.autoPlay && this.setAutoPlay();

        if (+this.settings.pauseOnHover) {
            this.$slider.hover(function () {
                _this.$slider.addClass('slidePause');
                _this.setPause();

            }, function () {
                _this.$slider.removeClass('slidePause');
                if(!jQuery('.huge-it-wrap').hasClass('isPlayed')){
                    _this.setAutoPlay();
                }

            });
        }

        jQuery('.playSlider').on('click', function () {
            _this.setAutoPlay();
            jQuery('.huge-it-wrap').removeClass('isPlayed');
        });
        jQuery('.pauseSlider').on('click', function () {
            _this.setPause();
            jQuery('.huge-it-wrap').addClass('isPlayed');
        });

        this.$slideImages = this.$slides.find('img:eq(0)').addClass('huge-it-slide-image');

        this.setup();

        jQuery(window).resize(function(){
            _this.cropImage();

            jQuery('li.group').height(jQuery('.huge-it-slider').height());

            var k = +_this.settings.maxHeight / +_this.settings.maxWidth * jQuery(window).width() + +hugeitSliderObj.thumb_height + 1;

            $('.huge-it-wrap').height(k);
        });

        jQuery('.huge-it-slider > li').height(jQuery('.huge-it-slider').height());
    };

    Slider.prototype.setup = function () {
        var sliderWidth, sliderHeight;
        sliderWidth = +this.settings.maxWidth;
        sliderHeight = (this.settings.controls === 'thumbnail') ?
        +this.settings.maxHeight + +hugeitSliderObj.thumb_height + 3 * +hugeitSliderObj.slideshow_border_size + 2 * this.settings.thumbMargin
            : +this.settings.maxHeight;
        this.$sliderWrap.css({
            maxWidth: sliderWidth + 'px',
            maxHeight: sliderHeight + 'px'
        });

        switch (this.settings.controls) {
            case 'dot':
                this.setDots();
                break;
            case 'thumbnail':
                this.setThumbs();
                break;
            case 'none':
                break;
        }

        jQuery('.slider-description div').each(function(){
            if(jQuery(this).text().length > 300){
                var text = jQuery(this).text();
                jQuery(this).attr('title', text);
                text = jQuery(this).text().substring(0, 300) + '...';
                jQuery(this).text(text);
            }
        });

        this.cropImage();

        this.$currentSlide.css({'opacity': 1, 'z-index': 2});
    };

    Slider.prototype.cropImage = function(){

        var w = this.settings.maxWidth,
            h = this.settings.maxHeight,
            wT, hT, r, d, mTop, mLeft;

        if(jQuery(window).width() < +this.settings.maxWidth || jQuery(window).height() < +this.settings.maxHeight){
            w = jQuery(window).width();
            h = +this.settings.maxHeight / +this.settings.maxWidth * w;
            jQuery('.huge-it-slider').height(h);
        }

        if(jQuery('.huge-it-slide-bg').width() < +this.settings.maxWidth || jQuery('.huge-it-slide-bg').height() < +this.settings.maxHeight){
            w = jQuery('.huge-it-slide-bg').width();
        }

        switch (hugeitSliderObj.crop_image) {
            case 'stretch':
                this.$slideImages.css({
                    'width': '100%',
                    'height': h + 'px',
                    'visibility': 'visible',
                    'max-height': 'none'
                });
                break;
            case 'fill':
                this.$slideImages.each(function () {
                    wT = $(this)[0].naturalWidth;
                    hT = $(this)[0].naturalHeight;
                    if ((wT / hT) < (w / h)) {
                        r = w / wT;
                        d = (Math.abs(h - (hT * r))) * 0.5;
                        mTop = '-' + d + 'px';
                        $(this).css({
                            'height': hT * r,
                            'margin-left': 0,
                            'margin-right': 0,
                            'margin-top': mTop,
                            'visibility': 'visible',
                            'width': w,
                            'max-width': 'none',
                            'max-height': 'none'
                        });
                    } else {
                        r = h / hT;
                        d = (Math.abs(w - (wT * r))) * 0.5;
                        mLeft = '-' + d + 'px';
                        $(this).css({
                            'height': h,
                            'margin-left': mLeft,
                            'margin-right': mLeft,
                            'margin-top': 0,
                            'visibility': 'visible',
                            'width': wT * r,
                            'max-width': 'none',
                            'max-height': 'none'
                        });
                    }
                });
                break;
        }
    };

    Slider.prototype.setArrows = function () {
        var _this = this;

        this.$sliderWrap.append('<a href="#" class="huge-it-arrows huge-it-prev"></a><a href="#" class="huge-it-arrows huge-it-next"></a>');

        $('.huge-it-next', this.$sliderWrap).on('click', function (e) {
            e.preventDefault();
            _this.next();
        });

        $('.huge-it-prev', this.$sliderWrap).on('click', function (e) {
            e.preventDefault();
            _this.prev();
        });
    };

    Slider.prototype.next = function () {
        if (this.settings.transition === 'custom') {
            this.nextAnimIndex++;
        }

        if (this.currentPlace === this.totalSlides - 1) {
            this.transition(0, true);
        } else {
            this.transition(this.currentPlace + 1, true);
        }

        if(jQuery('li.group').eq(this.currentPlace).hasClass('video_iframe') && jQuery('.huge-it-slider').attr('data-autoplay') == 1){
            jQuery('li.group').eq(this.currentPlace).find('.playButton').click();
        }

        var width = (Math.min(jQuery('.huge-it-slide-bg').width(), +this.settings.maxWidth) - (2 * +hugeitSliderObj.thumb_count_slides * this.settings.thumbMargin)) / +hugeitSliderObj.thumb_count_slides + 1,
            position = parseFloat($('.huge-it-thumb-wrap').css('marginLeft'));

        position = position.toFixed(4) - width.toFixed(4);

        if (position >= (this.totalSlides - hugeitSliderObj.thumb_count_slides) * (-width)) {
            $('.huge-it-thumb-wrap').css({
                'marginLeft': position + 'px'
            });
        }

        if (this.currentPlace == 0) {
            $('.huge-it-thumb-wrap').css({
                'marginLeft': '0'
            });
        }

        if(this.settings.controls === 'thumbnail'){
            jQuery('li.group').height(jQuery('.huge-it-slider').height());
        }
    };

    Slider.prototype.prev = function () {
        if (this.settings.transition === 'custom') {
            this.nextAnimIndex--;
        }

        if (this.currentPlace == 0) {
            this.transition(this.totalSlides - 1, false);
        } else {
            this.transition(this.currentPlace - 1, false);
        }

        if(jQuery('li.group').eq(this.currentPlace).hasClass('video_iframe') && jQuery('.huge-it-slider').attr('data-autoplay') == 1){
            jQuery('li.group').eq(this.currentPlace).find('.playButton').click();
        }

        var width = (Math.min(jQuery('.huge-it-slide-bg').width(), +this.settings.maxWidth) - (2 * +hugeitSliderObj.thumb_count_slides * this.settings.thumbMargin)) / +hugeitSliderObj.thumb_count_slides + 1,
        position = parseFloat($('.huge-it-thumb-wrap').css('marginLeft'));

        position = position.toFixed(4) + width.toFixed(4);

        if (position <= 0) {
            $('.huge-it-thumb-wrap').css({
                'marginLeft': position + 'px'
            });
        }

        if (this.currentPlace == this.totalSlides - 1) {
            position = (this.totalSlides - hugeitSliderObj.thumb_count_slides) * (-width);
            $('.huge-it-thumb-wrap').css({
                'marginLeft': position + 'px'
            });
        }

        if(this.settings.controls === 'thumbnail'){
            jQuery('li.group').height(jQuery('.huge-it-slider').height());
        }
    };

    Slider.prototype.setKeys = function () {
        var _this = this;

        $(document).on('keydown', function (e) {
            if (e.keyCode === 39) {
                _this.next();
            } else if (e.keyCode === 37) {
                _this.prev();
            }
        });
    };

    Slider.prototype.setAutoPlay = function () {
        var _this = this;

        if(!this.$slider.hasClass('slidePause')){
            this.cycling = setTimeout(function () {
                _this.next();
            }, this.settings.delay);
        }
    };

    Slider.prototype.setPause = function () {
        clearTimeout(this.cycling);
    };

    Slider.prototype.setDots = function () {
        var _this = this;

        this.$dotWrap = $('<div class="huge-it-dot-wrap" />').appendTo(this.$sliderWrap);

        for (var i = 0; i < this.totalSlides; i++) {
            var $thumb = $('<a />')
                .attr('href', '#')
                .data('huge-it-num', i);

            $thumb.appendTo(this.$dotWrap);
        }

        this.$dotWrapLinks = this.$dotWrap.find('a');

        this.$dotWrapLinks.eq(this.settings.startSlide).addClass('active');

        this.$dotWrap.on('click', 'a', function (e) {
            e.preventDefault();

            _this.transition(parseInt($(this).data('huge-it-num')));
        });
    };

    Slider.prototype.setThumbs = function () {
        var _this = this,
            width = (Math.min(jQuery('.huge-it-slide-bg').width(), +this.settings.maxWidth) - (2 * +hugeitSliderObj.thumb_count_slides * this.settings.thumbMargin)) / +hugeitSliderObj.thumb_count_slides;

        this.$thumbWrap = $('<div class="huge-it-thumb-wrap" />').appendTo(this.$sliderWrap);

        this.$slider.parents('.huge-it-wrap').find('.huge-it-thumb-wrap').css({
            width: this.totalSlides * (width + 2) + 'px',
            position: 'absolute'
        });

        var k = +this.settings.maxHeight / +this.settings.maxWidth * jQuery(window).width() + +hugeitSliderObj.thumb_height + 1;

        $('.huge-it-wrap').height(k);

        for (var i = 0; i < this.totalSlides; i++) {
            var $thumb = $('<a />')
                .css({
                    width: width + 'px',
                    margin: this.settings.thumbMargin + 'px'
                })
                .attr('href', '#')
                .data('huge-it-num', i);

            this.$slideImages.eq(i).clone()
                .removeAttr('style')
                .appendTo(this.$thumbWrap)
                .wrap($thumb);
        }

        this.$thumbWrapLinks = this.$thumbWrap.find('a');

        this.$thumbWrap.children().last().css('margin-right', -10);

        this.$thumbWrapLinks.eq(this.settings.startSlide).addClass('active');

        this.$thumbWrap.on('click', 'a', function (e) {
            e.preventDefault();

            _this.transition(parseInt($(this).data('huge-it-num')));
        });
    };

    Slider.prototype.captions = function () {
        var _this = this,
            $captions = this.$slides.find('.huge-it-caption');

        $captions.css({
            opacity: 0
        });

        this.$currentSlide.find('.huge-it-caption').css('opacity', 1);

        $captions.each(function () {
            $(this).css({
                transition: 'opacity ' + _this.settings.transitionDuration + 'ms linear',
                backfaceVisibility: 'hidden'
            });
        });
    };

    Slider.prototype.transition = function (slideNum, forward) {
        if (!this.inProgress) {
            if (slideNum !== this.currentPlace) {
                if (typeof forward === 'undefined') {
                    forward = (slideNum > this.currentPlace);
                }

                switch (this.settings.controls) {
                    case 'dot':
                        this.$dotWrapLinks.eq(this.currentPlace).removeClass('active');
                        this.$dotWrapLinks.eq(slideNum).addClass('active');
                        break;
                    case 'thumbnail':
                        this.$thumbWrapLinks.eq(this.currentPlace).removeClass('active');
                        this.$thumbWrapLinks.eq(slideNum).addClass('active');
                        break;
                    case 'none':
                        break;
                }

                this.$nextSlide = this.$slides.eq(slideNum);

                this.currentPlace = slideNum;

                if (jQuery('li.group').eq(this.currentPlace - 1).hasClass('video_iframe') || jQuery('li.group').eq(this.currentPlace).hasClass('video_iframe')) {
                    var streffect = this.settings.transition;
                    if (streffect == "cube_v" || streffect == "cube_h" || streffect == "none" || streffect == "fade") {
                        new Transition(this, this.settings.transition, forward);
                    } else {
                        new Transition(this, 'fade', forward);
                    }
                } else {
                    new Transition(this, this.settings.transition, forward);
                }

            }
        }
    };

    function Transition(Slider, transition, forward) {
        this.Slider = Slider;
        this.Slider.inProgress = true;
        this.forward = forward;
        this.transition = transition;

        if (this.transition === 'custom') {
            this.customAnims = this.Slider.settings.customTransitions;
        }

        if (this.transition === 'custom') {
            var _this = this;
            $.each(this.customAnims, function (i, obj) {
                if ($.inArray(obj, _this.anims) === -1) {
                    _this.customAnims.splice(i, 1);
                }
            });
        }

        this.fallback3d = this.Slider.settings.fallback3d;

        this.init();
    }

    Transition.prototype.fallback = 'fade';

    Transition.prototype.anims = ['cube_h', 'cube_v', 'fade', 'slice_h', 'slice_v', 'slide_h', 'slide_v', 'scale_out', 'scale_in', 'block_scale', 'kaleidoscope', 'fan', 'blind_h', 'blind_v'];

    Transition.prototype.customAnims = [];

    Transition.prototype.init = function () {
        this[this.transition]();
    };

    Transition.prototype.before = function (callback) {
        var _this = this;

        this.Slider.$currentSlide.css('z-index', 2);
        this.Slider.$nextSlide.css({'opacity': 1, 'z-index': 1});

        if (this.Slider.cssTransitions) {
            this.Slider.$currentSlide.find('.huge-it-caption').css('opacity', 0);
            this.Slider.$nextSlide.find('.huge-it-caption').css('opacity', 1);
        } else {
            this.Slider.$currentSlide.find('.huge-it-caption').animate({'opacity': 0}, _this.Slider.settings.transitionDuration);
            this.Slider.$nextSlide.find('.huge-it-caption').animate({'opacity': 1}, _this.Slider.settings.transitionDuration);
        }

        if (typeof this.setup === 'function') {
            var transition = this.setup();

            setTimeout(function () {
                callback(transition);
            }, 20);
        } else {
            this.execute();
        }

        if (this.Slider.cssTransitions) {
            $(this.listenTo).one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', $.proxy(this.after, this));
        }
    };

    Transition.prototype.after = function () {
        this.Slider.$sliderBG.removeAttr('style');
        this.Slider.$slider.removeAttr('style');
        this.Slider.$currentSlide.removeAttr('style');
        this.Slider.$nextSlide.removeAttr('style');
        var h = jQuery('.huge-it-slider').height() + 'px';
        this.Slider.$currentSlide.css({
            zIndex: 1,
            opacity: 0,
            height: h
        });
        this.Slider.$nextSlide.css({
            zIndex: 2,
            opacity: 1,
            height: h
        });

        if (typeof this.reset === 'function') {
            this.reset();
        }

        if (this.Slider.settings.autoPlay && !jQuery('.huge-it-wrap').hasClass('isPlayed')) {
            clearTimeout(this.Slider.cycling);
            this.Slider.setAutoPlay();
        }

        this.Slider.$currentSlide = this.Slider.$nextSlide;

        this.Slider.inProgress = false;

    };

    Transition.prototype.fade = function () {
        var _this = this;

        if (this.Slider.cssTransitions) {
            this.setup = function () {
                _this.listenTo = _this.Slider.$currentSlide;

                _this.Slider.$currentSlide.css('transition', 'opacity ' + _this.Slider.settings.transitionDuration + 'ms linear');
            };

            this.execute = function () {
                _this.Slider.$currentSlide.css('opacity', 0);
            }
        } else {
            this.execute = function () {
                _this.Slider.$currentSlide.animate({'opacity': 0}, _this.Slider.settings.transitionDuration, function () {
                    _this.after();
                });
            }
        }

        this.before($.proxy(this.execute, this));
    };

    Transition.prototype.cube = function (tz, ntx, nty, nrx, nry, wrx, wry) {
        if (!this.Slider.cssTransitions || !this.Slider.cssTransforms3d) {
            return this[this['fallback3d']]();
        }

        var _this = this;

        this.setup = function () {
            _this.listenTo = _this.Slider.$slider;

            this.Slider.$sliderBG.css('perspective', 1000);

            _this.Slider.$currentSlide.css({
                transform: 'translateZ(' + tz + 'px)',
                backfaceVisibility: 'hidden'
            });

            _this.Slider.$nextSlide.css({
                opacity: 1,
                backfaceVisibility: 'hidden',
                transform: 'translateY(' + nty + 'px) translateX(' + ntx + 'px) rotateY(' + nry + 'deg) rotateX(' + nrx + 'deg)'
            });

            _this.Slider.$slider.css({
                transform: 'translateZ(-' + tz + 'px)',
                transformStyle: 'preserve-3d'
            });
        };

        this.execute = function () {
            _this.Slider.$slider.css({
                transition: 'all ' + _this.Slider.settings.transitionDuration + 'ms ease-in-out',
                transform: 'translateZ(-' + tz + 'px) rotateX(' + wrx + 'deg) rotateY(' + wry + 'deg)'
            });
        };

        this.before($.proxy(this.execute, this));
    };

    Transition.prototype.none = function () {

        this.Slider.settings.transitionDuration = 1;

        if (this.forward) {
            this.cube(1, 1, 0, 0, 0, 0, 0);
        } else {
            this.cube(1, -1, 0, 0, 0, 0, 0);
        }
    };

    Transition.prototype.cube_h = function () {
        var dimension = $(this.Slider.$slides).width() / 2;

        if (this.forward) {
            this.cube(dimension, dimension, 0, 0, 90, 0, -90);
        } else {
            this.cube(dimension, -dimension, 0, 0, -90, 0, 90);
        }
    };

    Transition.prototype.cube_v = function () {
        var dimension = $(this.Slider.$slides).height() / 2;

        if (this.forward) {
            this.cube(dimension, 0, -dimension, 90, 0, -90, 0);
        } else {
            this.cube(dimension, 0, dimension, -90, 0, 90, 0);
        }
    };

    Transition.prototype.grid = function (cols, rows, ro, tx, ty, sc, op) {
        if (!this.Slider.cssTransitions) {
            return this[this['fallback']]();
        }

        var _this = this;

        this.setup = function () {
            var count = (_this.Slider.settings.transitionDuration) / (cols + rows);

            function gridlet(width, height, t, l, top, left, src, imgWidth, imgHeight, c, r) {
                var delay = (c + r) * count;

                return $('<div class="huge-it-gridlet" />').css({
                    width: width,
                    height: height,
                    top: t,
                    left: l,
                    backgroundImage: 'url(' + src + ')',
                    backgroundPosition: '-' + left + 'px -' + top + 'px',
                    backgroundSize: imgWidth + 'px ' + imgHeight + 'px',
                    transition: 'all ' + _this.Slider.settings.transitionDuration + 'ms ease-in-out ' + delay + 'ms',
                    transform: 'none'
                });
            }

            _this.$img = _this.Slider.$currentSlide.find('img.huge-it-slide-image');

            _this.$grid = $('<div />').addClass('huge-it-grid');

            _this.Slider.$currentSlide.prepend(_this.$grid);

            var imgWidth = _this.$img.width(),
                imgHeight = _this.$img.height(),
                imgSrc = _this.$img.attr('src'),
                colWidth = Math.floor(imgWidth / cols),
                rowHeight = Math.floor(imgHeight / rows),
                colRemainder = imgWidth - (cols * colWidth),
                colAdd = Math.ceil(colRemainder / cols),
                rowRemainder = imgHeight - (rows * rowHeight),
                rowAdd = Math.ceil(rowRemainder / rows),
                leftDist = 0,
                l = (_this.$grid.width() - _this.$img.width()) / 2;

            tx = tx === 'auto' ? imgWidth : tx;
            tx = tx === 'min-auto' ? -imgWidth : tx;
            ty = ty === 'auto' ? imgHeight : ty;
            ty = ty === 'min-auto' ? -imgHeight : ty;

            for (var i = 0; i < cols; i++) {
                var t = (_this.$grid.height() - _this.$img.height()) / 2,
                    topDist = 0,
                    newColWidth = colWidth;

                if (colRemainder > 0) {
                    var add = colRemainder >= colAdd ? colAdd : colRemainder;
                    newColWidth += add;
                    colRemainder -= add;
                }

                for (var j = 0; j < rows; j++) {
                    var newRowHeight = rowHeight,
                        newRowRemainder = rowRemainder;

                    if (newRowRemainder > 0) {
                        add = newRowRemainder >= rowAdd ? rowAdd : rowRemainder;
                        newRowHeight += add;
                        newRowRemainder -= add;
                    }

                    _this.$grid.append(gridlet(newColWidth, newRowHeight, t, l, topDist, leftDist, imgSrc, imgWidth, imgHeight, i, j));

                    topDist += newRowHeight;
                    t += newRowHeight;
                }

                leftDist += newColWidth;
                l += newColWidth;
            }

            _this.listenTo = _this.$grid.children().last();

            _this.$grid.show();
            _this.$img.css('opacity', 0);

            _this.$grid.children().first().addClass('huge-it-top-left');
            _this.$grid.children().last().addClass('huge-it-bottom-right');
            _this.$grid.children().eq(rows - 1).addClass('huge-it-bottom-left');
            _this.$grid.children().eq(-rows).addClass('huge-it-top-right');
        };

        this.execute = function () {
            _this.$grid.children().css({
                opacity: op,
                transform: 'rotate(' + ro + 'deg) translateX(' + tx + 'px) translateY(' + ty + 'px) scale(' + sc + ')'
            });
        };

        this.before($.proxy(this.execute, this));

        this.reset = function () {
            _this.$img.css('opacity', 1);
            _this.$grid.remove();
        }
    };

    Transition.prototype.slice_h = function () {
        this.grid(1, 8, 0, 'min-auto', 0, 1, 0);
    };

    Transition.prototype.slice_v = function () {
        this.grid(10, 1, 0, 0, 'auto', 1, 0);
    };

    Transition.prototype.slide_v = function () {
        var dir = this.forward ?
            'min-auto' :
            'auto';

        this.grid(1, 1, 0, 0, dir, 1, 1);
    };

    Transition.prototype.slide_h = function () {
        var dir = this.forward ?
            'min-auto' :
            'auto';

        this.grid(1, 1, 0, dir, 0, 1, 1);
    };

    Transition.prototype.scale_out = function () {
        this.grid(1, 1, 0, 0, 0, 1.5, 0);
    };

    Transition.prototype.scale_in = function () {
        this.grid(1, 1, 0, 0, 0, .5, 0);
    };

    Transition.prototype.block_scale = function () {
        this.grid(8, 6, 0, 0, 0, .6, 0);
    };

    Transition.prototype.kaleidoscope = function () {
        this.grid(10, 8, 0, 0, 0, 1, 0);
    };

    Transition.prototype.fan = function () {
        this.grid(1, 10, 45, 100, 0, 1, 0);
    };

    Transition.prototype.blind_v = function () {
        this.grid(1, 8, 0, 0, 0, .7, 0);
    };

    Transition.prototype.blind_h = function () {
        this.grid(10, 1, 0, 0, 0, .7, 0);
    };

    Transition.prototype.random = function () {
        this[this.anims[Math.floor(Math.random() * this.anims.length)]]();
    };

    Transition.prototype.custom = function () {
        if (this.Slider.nextAnimIndex < 0) {
            this.Slider.nextAnimIndex = this.customAnims.length - 1;
        }
        if (this.Slider.nextAnimIndex === this.customAnims.length) {
            this.Slider.nextAnimIndex = 0;
        }

        this[this.customAnims[this.Slider.nextAnimIndex]]();
    };

    var testBrowser = {
        browserVendors: ['', '-webkit-', '-moz-', '-ms-', '-o-', '-khtml-'],

        domPrefixes: ['', 'Webkit', 'Moz', 'ms', 'O', 'Khtml'],

        testDom: function (prop) {
            var i = this.domPrefixes.length;

            while (i--) {
                if (typeof document.body.style[this.domPrefixes[i] + prop] !== 'undefined') {
                    return true;
                }
            }

            return false;
        },

        cssTransitions: function () {
            if (typeof window.Modernizr !== 'undefined' && Modernizr.csstransitions !== 'undefined') {
                return Modernizr.csstransitions;
            }

            return this.testDom('Transition');
        },

        cssTransforms3d: function () {
            if (typeof window.Modernizr !== 'undefined' && Modernizr.csstransforms3d !== 'undefined') {
                return Modernizr.csstransforms3d;
            }

            if (typeof document.body.style['perspectiveProperty'] !== 'undefined') {
                return true;
            }

            return this.testDom('Perspective');
        }
    };

    $.fn['sliderPlugin'] = function (settings) {
        return this.each(function () {
            if (!$.data(this, 'sliderPlugin')) {
                $.data(this, 'sliderPlugin', new Slider(this, settings));
            }
        });
    }

})(window.jQuery, window, window.document);

jQuery(window).load(function () {
    jQuery('div[class*=slider-loader-]').css({
        display: 'none'
    });
    jQuery('.huge-it-wrap').css({
        opacity: '1'
    });
    if(jQuery('li.group').first().hasClass('video_iframe') && jQuery('.huge-it-slider').attr('data-autoplay') == 1){
        jQuery('.playButton').first().click();
    }
});

var tag = document.createElement('script');
tag.src = "//www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var playerInfoList = [], YTplayer = {}, i;
jQuery('.huge_it_youtube_iframe').each(function () {
    var id = jQuery(this).attr('id'),
        videoId = jQuery(this).attr('data-id'),
        controls = jQuery(this).attr('data-controls'),
        showinfo = jQuery(this).attr('data-showinfo'),
        volume = jQuery(this).attr('data-volume'),
        quality = jQuery(this).attr('data-quality'),
        rel = jQuery(this).attr('data-rel'),
        index = jQuery(this).parent().find('div[class*=youtube_play_icon_]').attr('data-index'),
        width = jQuery(this).attr('data-width'),
        height = jQuery(this).attr('data-height'),
        delay = jQuery(this).attr('data-delay');
    YTplayer[i] = {
        id: id,
        videoId: videoId,
        controls: controls,
        showinfo: showinfo,
        volume: volume,
        quality: quality,
        rel: rel,
        index: index,
        width: width,
        height: height,
        delay: delay
    };
    playerInfoList.push(YTplayer[i]);
    i++;
});

function onYouTubeIframeAPIReady() {
    if (typeof playerInfoList === 'undefined')
        return;

    for (var i = 0; i < playerInfoList.length; i++) {
        createPlayer(playerInfoList[i]);
    }
}

function createPlayer(playerInfo) {
    var _player = new YT.Player(playerInfo.id, {
        width: playerInfo.width,
        height: playerInfo.height,
        videoId: playerInfo.videoId,
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        },
        playerVars: {
            'controls': playerInfo.controls,
            'showinfo': playerInfo.showinfo,
            'volume': playerInfo.volume,
            'quality': playerInfo.quality,
            'rel': playerInfo.rel
        }

    });

    function onPlayerReady(e) {
        var nextButton = jQuery('.huge-it-arrows.huge-it-next'),
            prevButton = jQuery('.huge-it-arrows.huge-it-prev');

        _player.setVolume(playerInfo.volume);
        e.target.setPlaybackQuality(playerInfo.quality);

        nextButton.on('click', function () {
            _player.pauseVideo();
            jQuery('.playSlider').click();
        });
        prevButton.on('click', function () {
            _player.pauseVideo();
            jQuery('.playSlider').click();
        });


        var playButton = jQuery('#' + playerInfo.id).parent().find('.playButton');
        playButton.on("click", function() {
            _player.playVideo();
        });

        e.target.setPlaybackQuality('small');
    }

    function onPlayerStateChange(e) {

        e.target.setPlaybackQuality(playerInfo.quality);

        switch (e.data) {
            case 0:
                jQuery('.playSlider').click();
                break;
            case 1:
                jQuery('.pauseSlider').click();
                break;
            case 2:
                var pauseTime = _player.getCurrentTime();
                setTimeout(function () {
                    if (_player.getCurrentTime() == pauseTime) {
                        jQuery('.playSlider').click();
                    }
                }, +playerInfo.pause_time);
                break;
        }
    }

    return _player;
}

jQuery('iframe.huge_it_vimeo_iframe').each(function () {
    Froogaloop(this).addEvent('ready', ready);
});

function ready(player_id) {
    var froogaloop = $f(player_id),
        arrows = jQuery('.huge-it-arrows.huge-it-prev, .huge-it-arrows.huge-it-next');

    froogaloop = $f(player_id);

    arrows.on('click', function () {
        froogaloop.api('pause');
    });

    froogaloop.addEvent('ready', function () {
        froogaloop.addEvent('finish', onFinish);
        froogaloop.addEvent('pause', onPause);
        froogaloop.addEvent('finish', onFinish);
        froogaloop.addEvent('play', onPlay);
        froogaloop.api('setVolume', jQuery('li.group').find('.huge_it_vimeo_iframe').attr('data-volume'));
        froogaloop.api('setColor', jQuery('li.group').find('.huge_it_vimeo_iframe').attr('data-controlColor'));
    });

    var playButton = jQuery('#' + player_id).parent().find('.playButton');
    playButton.on("click", function() {
        froogaloop.api("play");
    });

    function onPlay() {
        jQuery('.pauseSlider').click();
    }

    function onFinish() {
        jQuery('.playSlider').click();
    }

    function onPause(data) {
        var pauseTime = data.seconds;
        setTimeout(function () {
            if (data.seconds == pauseTime) {
                jQuery('.playSlider').click();
            }
        }, 3000);
    }

}
