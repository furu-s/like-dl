import React from 'react';
import PropTypes from 'prop-types';
import {connect} from 'react-redux'
import ImageList from '../components/image-list';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import {fetchSearchedTweets} from '../actions/index';

class App extends React.Component {
  constructor(props) {
    super(props);
  }

  componentDidMount() {
    const { dispatch, selectedSubreddit } = this.props;
    dispatch(fetchSearchedTweets());
  }

  render() {
    return (
      <MuiThemeProvider>
        <ImageList
          mediaData={this.props.tweets}
          isChecked={this.props.isChecked}
        />
      </MuiThemeProvider>
    )
  }
}

App.propTypes = {
  tweets: PropTypes.array.isRequired,
  isChecked: PropTypes.array.isRequired,
  dispatch: PropTypes.func.isRequired
}

function mapStateToProps(state) {
  console.log(state);
  const {
    tweets,
    isChecked
  } = state || {
    tweets: [],
    isChecked: []
  };

  return {
    tweets,
    isChecked
  };
}

export default connect(mapStateToProps)(App);
