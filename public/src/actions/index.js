import fetch from 'isomorphic-fetch';

export const REQUEST_TWEETS = 'REQUEST_TWEETS';
export const RECEIVE_TWEETS = 'RECEIVE_TWEETS';
export const FETCH_TWEETS = 'FETCH_TWEETS';

function requestTweets() {
  return {
    type: REQUEST_TWEETS
  };
}

export function fetchSearchedTweets() {
  const headers = new Headers({
    "Content-Type": "application/json"
  });
  const fetchInit = {
    method: 'GET',
    headers: headers
  }
  return dispatch => {
    dispatch(requestTweets());
    return fetch(`/Search/`, fetchInit)
      .then(response => response.json())
      .then(json => dispatch(receiveTweets(json)));
  };
}

function receiveTweets(json_data) {
  return {
    type: RECEIVE_TWEETS,
    tweets: json_data
  };
}
