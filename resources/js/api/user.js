/*
  PUT  /api/v1/user
*/
putUpdateUser: function( public_visibility, real_name, interests, location, favourite_games ){
    return axios.put( ROAST_CONFIG.API_URL + '/user',
      {
        public_visibility: public_visibility,
        real_name: real_name,
        interests: interests,
        location: location,
        favourite_games: favourite_games
      }
    );
  }