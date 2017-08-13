import React from 'react';
import injectTapEventPlugin from 'react-tap-event-plugin';
import App from './app';

injectTapEventPlugin();

export default class Root extends React.Component {
  render() {
    return (
      <App />
    );
  }
}
