(function() {
   Polymer({
      is: 'st-legend',
      properties: {
         content: Object,
         url: String
      },
      handler: handler,
      toggleLegend: toggleLegend
   });

   function handler(response) {
      this.content = response.detail.response;
   }

   function toggleLegend() {
      var panel = this.$.panel;
      panel.classList.toggle('hide');
   }
})();
