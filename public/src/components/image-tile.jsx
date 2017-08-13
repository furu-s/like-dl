import React from 'react';
import PropTypes from 'prop-types';
import {GridTile} from 'material-ui/GridList';
import Checkbox from 'material-ui/Checkbox';

export default function ImageTile(props) {
  return (
    <GridTile
      title={props.title}
    >
      <img src={props.mediaData.media_thumb_url} />
      <Checkbox />
    </GridTile>
  );
}

ImageTile.propTypes = {
  mediaData: PropTypes.shape({
    media_url: PropTypes.string,
    media_thumb_url: PropTypes.string,
    media_id: PropTypes.number
  }),
  isChecked: PropTypes.bool
};
