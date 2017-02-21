(function() {
   Polymer({
      is: 'st-badges',
      properties: {
         badges: Array,
         iconColor: {type: String, value: 'gray'}
      },
      generateClass: generateClass
   });

   function generateClass(name) {
      return name.toLowerCase();
   }
})();
