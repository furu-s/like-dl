import {
  REQUEST_TWEETS,
  RECEIVE_TWEETS,
  FETCH_TWEETS
} from '../actions/index.js';

function tweets(
  state = {
    isFetching: false,
    tweets: [],
    isChecked: []
  },
  action
) {
  switch (action.type) {
    case REQUEST_TWEETS:
      return Object.assign({}, state, {
        isFetching: true
      });
    case RECEIVE_TWEETS:
      return Object.assign({}, state, {
        isFetching: false,
        tweets: action.tweets,
        isChecked: new Array(action.tweets.length).map(() => false)
      });
    default:
      return state;
  }
}

export default tweets;
