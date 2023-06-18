window._ASP_load = function () {
    "use strict";
    let $ = WPD.dom;

    window.ASP.instances = {
        instances: [],
        get: function(id, instance) {
            this.clean();
            if ( typeof id === 'undefined' || id == 0) {
                return this.instances;
            } else {
                if ( typeof instance === 'undefined' ) {
                    let ret = [];
                    for ( let i=0; i<this.instances.length; i++ ) {
                        if ( this.instances[i].o.id == id ) {
                            ret.push(this.instances[i]);
                        }
                    }
                    return ret.length > 0 ? ret : false;
                } else {
                    for ( let i=0; i<this.instances.length; i++ ) {
                        if ( this.instances[i].o.id == id && this.instances[i].o.iid == instance ) {
                            return this.instances[i];
                        }
                    }
                }
            }
            return false;
        },
        set: function(obj) {
            if ( !this.exist(obj.o.id, obj.o.iid) ) {
                this.instances.push(obj);
                return true;
            } else {
                return false;
            }
        },
        exist: function(id, instance) {
            this.clean();
            for ( let i=0; i<this.instances.length; i++ ) {
                if ( this.instances[i].o.id == id ) {
                    if (typeof instance === 'undefined') {
                        return true;
                    } else if (this.instances[i].o.iid == instance) {
                        return true;
                    }
                }
            }
            return false;
        },
        clean: function() {
            let unset = [], _this = this;
            this.instances.forEach(function(v, k){
                if ( $('.asp_m_' + v.o.rid).length == 0 ) {
                    unset.push(k);
                }
            });
            unset.forEach(function(k){
                if ( typeof _this.instances[k] !== 'undefined' ) {
                    _this.instances[k].destroy();
                    _this.instances.splice(k, 1);
                }
            });
        },
        destroy: function(id, instance) {
            let i = this.get(id, instance);
            if ( i !== false ) {
                if ( Array.isArray(i) ) {
                    i.forEach(function (s) {
                        s.destroy();
                    });
                    this.instances = [];
                } else {
                    let u = 0;
                    this.instances.forEach(function(v, k){
                        if ( v.o.id == id && v.o.iid == instance) {
                            u = k;
                        }
                    });
                    i.destroy();
                    this.instances.splice(u, 1);
                }
            }
        }
    };

    window.ASP.initialized = false;
    window.ASP.initializeSearchByID = function (id) {
        let instances = ASP.getInstances();
        if (typeof id !== 'undefined' && typeof id != 'object' ) {
            if ( typeof instances[id] !== 'undefined' ) {
                let ni = [];
                ni[id] = instances[id];
                instances = ni;
            } else {
                return false;
            }
        }
        let initialized = 0;
        instances.forEach(function (data, i) {
            // noinspection JSUnusedAssignment
            $('.asp_m_' + i).forEach(function(el){
                let $el = $(el);
                if ( typeof $el.get(0).hasAsp != 'undefined') {
                    ++initialized;
                    return true;
                }
                el.hasAsp = true;
                ++initialized;
                return $el.ajaxsearchpro(data);
            });
        });
    }

    window.ASP.getInstances = function() {
        if ( typeof window.ASP_INSTANCES !== 'undefined' ) {
            return window.ASP_INSTANCES;
        } else {
            let instances = [];
            $('.asp_init_data').forEach(function (el) {
                if (typeof el.dataset['aspdata'] === "undefined") return true;   // Do not return false, it breaks the loop!
                let data = WPD.Base64.decode(el.dataset['aspdata']);
                if (typeof data === "undefined" || data == "") return true;

                instances[el.dataset['aspId']] = JSON.parse(data);
            });
            return instances;
        }
    }

// Call this function if you need to initialize an instance that is printed after an AJAX call
// Calling without an argument initializes all instances found.
    window.ASP.initialize = function (id) {
        // Some weird ajax loader problem prevention
        if (typeof ASP.version == 'undefined')
            return false;

        if( !!window.IntersectionObserver ){
            if ( ASP.script_async_load || ASP.init_only_in_viewport ) {
                let searches = document.querySelectorAll('.asp_w_container');
                if ( searches.length ) {
                    let observer = new IntersectionObserver(function(entries){
                        entries.forEach(function(entry){
                            if ( entry.isIntersecting ) {
                                ASP.initializeSearchByID(entry.target.dataset.id);
                                observer.unobserve(entry.target);
                            }
                        });
                    });
                    searches.forEach(function(search){
                        observer.observe(search);
                    });
                }
                ASP.getInstances().forEach(function(inst, id){
                    if ( inst.compact.enabled == 1 && inst.compact.position == 'fixed' ) {
                        ASP.initializeSearchByID(id);
                    }
                });
            } else {
                ASP.initializeSearchByID(id);
            }
        } else {
            ASP.initializeSearchByID(id);
        }

        ASP.initializeMutateDetector();
        ASP.initializeHighlight();
        ASP.initializeOtherEvents();

        ASP.initialized = true;
    };

    window.ASP.initializeHighlight = function() {
        let _this = this;
        if (_this.highlight.enabled) {
            let data = localStorage.getItem('asp_phrase_highlight');
            localStorage.removeItem('asp_phrase_highlight');

            if (data != null) {
                data = JSON.parse(data);
                _this.highlight.data.forEach(function (o) {
                    if (o.id == data.id) {
                        let selector = o.selector != '' && $(o.selector).length > 0 ? o.selector : 'article',
                            $highlighted;
                        selector = $(selector).length > 0 ? selector : 'body';
                        // noinspection JSUnresolvedVariable
                        $(selector).highlight(data.phrase, {
                            element: 'span',
                            className: 'asp_single_highlighted_' + data.id,
                            wordsOnly: o.whole,
                            excludeParents: '.asp_w, .asp-try'
                        });
                        $highlighted = $('.asp_single_highlighted_' + data.id);
                        if (o.scroll && $highlighted.length > 0) {
                            let stop = $highlighted.offset().top - 120;
                            let $adminbar = $("#wpadminbar");
                            if ($adminbar.length > 0)
                                stop -= $adminbar.height();
                            // noinspection JSUnresolvedVariable
                            stop = stop + o.scroll_offset;
                            stop = stop < 0 ? 0 : stop;
                            $('html').animate({
                                "scrollTop": stop
                            }, 500);
                        }
                        return false;
                    }
                });
            }
        }
    };

    window.ASP.initializeOtherEvents = function() {
        let ttt, ts, $body = $('body'), _this = this;
        // Known slide-out and other type of menus to initialize on click
        ts = '#menu-item-search, .fa-search, .fa, .fas';
        // Avada theme
        ts = ts + ', .fusion-flyout-menu-toggle, .fusion-main-menu-search-open';
        // Be theme
        ts = ts + ', #search_button';
        // The 7 theme
        ts = ts + ', .mini-search.popup-search';
        // Flatsome theme
        ts = ts + ', .icon-search';
        // Enfold theme
        ts = ts + ', .menu-item-search-dropdown';
        // Uncode theme
        ts = ts + ', .mobile-menu-button';
        // Newspaper theme
        ts = ts + ', .td-icon-search, .tdb-search-icon';
        // Bridge theme
        ts = ts + ', .side_menu_button, .search_button';
        // Jupiter theme
        ts = ts + ', .raven-search-form-toggle';
        // Elementor trigger lightbox & other elementor stuff
        ts = ts + ', [data-elementor-open-lightbox], .elementor-button-link, .elementor-button';
        ts = ts + ', i[class*=-search], a[class*=-search]';

        // Attach this to the document ready, as it may not attach if this is loaded early
        $body.on('click touchend', ts, function () {
            clearTimeout(ttt);
            ttt = setTimeout(function () {
                _this.initializeSearchByID();
            }, 300);
        });

        // Elementor popup events (only works with jQuery)
        if ( typeof jQuery != 'undefined' ) {
            jQuery(document).on('elementor/popup/show', function(){
                setTimeout(function () {
                    _this.initializeSearchByID();
                }, 10);
            });
        }
    };

    window.ASP.initializeMutateDetector = function() {
        let t;
        if ( typeof ASP.detect_ajax != "undefined" && ASP.detect_ajax == 1 ) {
            let o = new MutationObserver(function() {
                clearTimeout(t);
                t = setTimeout(function () {
                    ASP.initializeSearchByID();
                }, 500);
            });
            o.observe(document.querySelector("body"), {subtree: true, childList: true});
        }
    };

    window.ASP.ready = function () {
        let _this = this;

        if (document.readyState === "complete" || document.readyState === "loaded"  || document.readyState === "interactive") {
            // document is already ready to go
            _this.initialize();
        } else {
            $(document).on('DOMContentLoaded', _this.initialize);
        }
    };

    window.ASP.loadScriptStack = function (stack) {
        let scriptTag;
        if ( stack.length > 0 ) {
            scriptTag = document.createElement('script');
            scriptTag.src = stack.shift()['src'];
            scriptTag.onload = function () {
                if ( stack.length > 0 ) {
                    window.ASP.loadScriptStack(stack)
                } else {
                    window.ASP.ready();
                }
            }
            document.body.appendChild(scriptTag);
        }
    }

    window.ASP.init = function () {
        // noinspection JSUnresolvedVariable
        if (ASP.script_async_load) {   // Opimized Normal
            // noinspection JSUnresolvedVariable
            window.ASP.loadScriptStack(ASP.additional_scripts);
        } else {
            if (typeof WPD.ajaxsearchpro !== 'undefined') {   // Classic normal
                window.ASP.ready();
            }
        }
    };


    window.WPD.intervalUntilExecute(window.ASP.init, function() {
        return typeof window.ASP.version != 'undefined' && $.fn.ajaxsearchpro != 'undefined'
    });
};
// Run on document ready
(function() {
    // Preload script executed?
    if ( typeof WPD != 'undefined' && typeof WPD.dom != 'undefined' ) {
        window._ASP_load();
    } else {
        document.addEventListener('wpd-dom-core-loaded', window._ASP_load);
    }
})();