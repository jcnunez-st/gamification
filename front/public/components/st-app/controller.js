(function() {
   Polymer({
      is: 'st-app',
      properties: {
         leaderboardUrl: String,
         legendUrl: String,
         tabs: Array,
         showTabSwitcher: Boolean
      },
      observers: [
         '_onRoutePathChanged(route.path)'
      ],
      ready: ready,
      _isInvalidRoute: _isInvalidRoute,
      _onRoutePathChanged: function (path) {
         if (!path || this._isInvalidRoute()) {
            this.set('route.path', '/home');
         }
         this.showTabSwitcher = (this.route.path != "/home");
      },
      configHandler: configHandler
   });

   function configHandler(response) {
      var apiConfig = response.detail.response.api;
      this.apiUrl = apiConfig.protocol + "://" + apiConfig.ip;
      this.leaderboardUrl = this.apiUrl + "/leaderboard";
      this.legendUrl = this.apiUrl + "/legend";
   }

   function ready() {
      this.leaderboardUrl = null;
      this.legendUrl = null;
      this.tabs = [{id: "leaderboard", href: "/#/leaderboard", label: "Leaderboard"}];
      this.showTabSwitcher = false;
   }

   function _isInvalidRoute() {
      var valid = false;
      var i = 0;
      if (this.tabs) {
         while (!valid && i < this.tabs.length) {
            if (this.data.page == this.tabs[i].id) {
               valid = true;
            }
            ++i;
         }
      }
      return !valid;
   }
})();
