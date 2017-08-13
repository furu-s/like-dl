import React from 'react';
import PropTypes from 'prop-types';
import {GridTile} from 'material-ui/GridList';
import Checkbox from 'material-ui/Checkbox';

export default function ImageTile(props) {
  return (
    <GridTile
      title={props.title}
    >
      <div className="tile-wrapper">
        <div className="image-tile">
          <img className="thumb-image" src={props.mediaData.media_thumb_url} />
        </div>
        <div className="checkbox-wrapper">
          <Checkbox />
        </div>
      </div>
    </GridTile>
  );
}

ImageTile.propTypes = {
  mediaData: PropTypes.shape({
    media_url: PropTypes.string,
    media_thumb_url: PropTypes.string,
    media_id: PropTypes.string
  }),
  isChecked: PropTypes.bool
};
