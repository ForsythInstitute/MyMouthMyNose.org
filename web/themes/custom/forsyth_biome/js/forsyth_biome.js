/**
 * @file
 * Placeholder file for custom sub-theme behaviors.
 *
 */
(function ($, Drupal) {

  /**
   * Use this behavior as a template for custom Javascript.
   */
  Drupal.behaviors.siteWideBehavior = {
    attach: function (context, settings) {

      //Hide the Highlighted region when all Drupal Messages have been closed
      $('.zurb-foundation-callout .close-button ').click(function() {
        console.log('Clicked the close-button.');
        setTimeout(_hideHighlighted, 1000);
      });
    }

  }; //End Behavior "siteWideBehavior

  /**
   * If all Drupal Messages have been hidden then hide the Highlighted region
   * @private
   */
  function _hideHighlighted(){
    //Get an array of Drupal Message elements
    var $msgs = $('.zurb-foundation-callout.callout');
    console.log("# messages = " + $msgs.length);
    var $visible = null;
    if ($msgs.length > 0) {
      $.each($msgs, function(msgkey, val) {
        $visible = !!$(val).is(":visible");
        //console.log("visible = " + $visible);
      });
      //If $visible is false then Hide the Highlighted Region
      if ( $visible === false ) {
        $('.region-highlighted.callout').fadeOut(500);
      }
    } else {
      $('.region-highlighted.callout').fadeOut(500);
    }
  }

})(jQuery, Drupal);
