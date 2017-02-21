(function() {
   Polymer({
      is: 'st-page-leaderboard',
      properties: {
         photoUrl: String,
         showLoading: {
            type: Boolean,
            value: true
         },
         url: String,
         users: {
            type: Array,
            value: []
         }
      },
      handler: handler
   });

   function handler(response) {
      this.users = response.detail.response;
      this.showLoading = false;
   }
})();
