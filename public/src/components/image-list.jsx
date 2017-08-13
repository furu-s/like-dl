import React from 'react';
import PropTypes from 'prop-types'
import {GridList} from 'material-ui/GridList';
import ImageTile from './image-tile';

export default function ImageList(props) {
  return (
    <GridList
      cellHeight={180}
    >
      {props.mediaData.map((mediaData, index) => {
        return (
          <ImageTile
            key={"image-tile-" + index}
            mediaData={mediaData}
            isChecked={props.isChecked[index]}
          />
        );
      })}
    </GridList>
  );
}

ImageList.propTypes = {
  mediaData: PropTypes.array,
  isChecked: PropTypes.array
};
