import React from 'react';
import injectTapEventPlugin from 'react-tap-event-plugin';
import App from './app';
import configureStore from '../stores/configureStore'
import { Provider } from 'react-redux'

injectTapEventPlugin();

const store = configureStore();

export default class Root extends React.Component {
  render() {
    return (
      <Provider store={store}>
        <App />
      </Provider>
    );
  }
}
