(function ( $, window, document, undefined ) {

    // Create the defaults once
    var pluginName = "loading",
        defaults = {
            'position': 	"overlay",      // right | inside | overlay
            'text': 		"",             // Text to display next to the loader
            'class': 		"fa fa-circle-o-notch fa-spin fa-3x fa-fw",    // loader CSS class
            'transparency': 0.7,            // background transparency for using with overlay

            // loader base Tag. Change to support bootstrap > 3.x
            'tpl': '<span class="loading-wrapper :wrapper">'+
                        '<i class=":class"></i><br/><span>:text</span>'+
                   '</span>',
            
            //true | false
            'disableSource': true,      
            'disableOthers': []
        };

    //The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        // Merge user options with default ones
        this.options = $.extend( {}, defaults, options );

        this._defaults     = defaults;
        this._name         = pluginName;
        this._loader       = null;                // Contain the loading tag element

        this.init();
    }

    // Contructor function for the plugin (only once on page load)
    function contruct() {

        if ( !$[pluginName] ) {
            $.loading = function( opts ) {
                $( "body" ).loading( opts );
            };
        }
    }

    Plugin.prototype = {

        init: function() {

            if( $( this.element ).is( "body") ) {
                this.options.position = "overlay";
            }
            this.show();
        },

        show: function() {

            var self = this,
                tpl = self.options.tpl.replace( ':wrapper', ' loading-show ' + ' loading-' + self.options.position );
            tpl = tpl.replace( ':class', self.options['class'] );
            tpl = tpl.replace( ':text', ( self.options.text !== "" ) ? self.options.text + ' ' : '' );
            self._loader = $( tpl );

            // Disable the element
            if( $( self.element ).is( "input, textarea" ) && true === self.options.disableSource ) {

                $( self.element ).attr( "disabled", "disabled" );

            }
            else if( true === self.options.disableSource ) {

                $( self.element ).addClass( "disabled" );

            }

            // Set position
            switch( self.options.position ) {

                case "inside":
                    $( self.element ).html( self._loader );
                    break;

                case "overlay":
                    var $wrapperTpl = null;

                    if( $( self.element ).is( "body") ) {
                        $wrapperTpl = $('<div class="loading-overlay" style="position:fixed; left:0; top:0; z-index: 99999; background: rgba(0,0,0,' + self.options.transparency + '); width: 100%; height: ' + $(window).height() + 'px;" />');
                        $( "body" ).prepend( $wrapperTpl );

                        $( window ).on('resize', function() {
                            $wrapperTpl.height( $(window).height() + 'px' );
                            self._loader.css({top: ($(window).height()/2 - self._loader.outerHeight()/2) + 'px' });
                        });
                    } else {
                        var cssPosition = $( self.element ).css('position'),
                            pos = {},
                            height = $( self.element ).outerHeight() + 'px',
                            width = $(self.element).css("width"); // $( self.element ).outerWidth() + 'px;

                        if( 'relative' === cssPosition || 'absolute' === cssPosition) {
                            pos = { 'top': 0,  'left': 0 };
                        } else {
                            pos = $( self.element ).position();
                        }
                        $wrapperTpl = $('<div class="loading-overlay" style="position:absolute; top: ' + pos.top + 'px; left: ' + pos.left + 'px; z-index: 99999; background: rgba(0,0,0,' + self.options.transparency + '); width: ' + width + '; height: ' + height + ';" />');
                        $( self.element ).prepend( $wrapperTpl );

                        $( window ).on('resize', function() {
                            $wrapperTpl.height( $( self.element ).outerHeight() + 'px' );
                            self._loader.css({top: ($wrapperTpl.outerHeight()/2 - self._loader.outerHeight()/2) + 'px' });
                        });
                    }

                    $wrapperTpl.html( self._loader );
                    self._loader.css({top: ($wrapperTpl.outerHeight()/2 - self._loader.outerHeight()/2) + 'px' });
                    break;

                default:
                    $( self.element ).after( self._loader );
                    break;
            }

            self.disableOthers();
        },

        hide: function() {

            if( "overlay" === this.options.position ) {
                $( this.element ).find( ".loading-overlay" ).first().slideUp();
            } else {

                $( this._loader ).remove();
                $( this.element ).text( $( this.element ).attr( "data-loading-label" ) );

            }

            $( this.element ).removeAttr("disabled").removeClass("disabled");

            this.enableOthers();
        },

        disableOthers: function() {
            $.each(this.options.disableOthers, function( i, e ) {
                var elt = $( e );
                if( elt.is( "button, input, textarea" ) ) {
                    elt.attr( "disabled", "disabled" );
                }
                else {
                    elt.addClass( "disabled" );
                }
            });
        },

        enableOthers: function() {
            $.each(this.options.disableOthers, function( i, e ) {
                var elt = $( e );
                if( elt.is( "button, input, textarea" ) ) {
                    elt.removeAttr( "disabled" );
                }
                else {
                    elt.removeClass( "disabled" );
                }
            });
        }
    };

    // Constructor
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if ( options && "hide" !== options || !$.data( this, "plugin_" + pluginName ) ) {
                $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
            } else {
                var elt = $.data( this, "plugin_" + pluginName );

                if( "hide" === options )    { elt.hide(); }
                else                        { elt.show(); }
            }
        });
    };

    contruct();

})( jQuery, window, document );