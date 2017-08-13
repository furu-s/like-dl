import React from 'react';
import ImageList from '../components/image-list';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';

export default class App extends React.Component {
  render() {
    return (
      <MuiThemeProvider>
        <ImageList
          mediaData={[{
            media_thumb_url: "https:\/\/pbs.twimg.com\/media\/DGwh_bfUMAAV55H.jpg",
            media_url: "https:\/\/pbs.twimg.com\/media\/DGwh_bfUMAAV55H.jpg",
            media_id: 895127799534465024
          }]}
          isChecked={[false]}
        />
      </MuiThemeProvider>
    )
  }
}
