import $ from 'jquery'
import _ from 'lodash'
import React from 'react'

import Tag from './tag'

export default React.createClass({

    getDefaultProps: function () {
        return {
            tags: [],
            onTagAdd: function() {},
            onTagClear: function() {}
        };
    },

    render: function () {
        return (
            <div className="component-tag-manager__list">
                { this.props.tags.map(tag => <Tag key={"tag_" + tag.id} id={tag.id} label={tag.title} onClear={this.props.onTagClear} />) }
            </div>
        )
    }
});