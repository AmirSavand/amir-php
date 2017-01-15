/**
 * Static class for Amir PHP system
 */
var Amir = {

  /**
   * Alert methods
   */
  Alert: {
    /**
     * Show alert
     */
    show: function (content, type) {
      type = type || "warning";
      $("#alert > div").html(content).removeClass().addClass("alert in alert-" + type).fadeIn();
    },
    /**
     * Hide alert
     */
    hide: function () {
      $("#alert > div").fadeOut(function () {
        $(this).removeClass();
      });
    }
  }
};
