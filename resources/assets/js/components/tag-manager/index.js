import $ from 'jquery'
import React from 'react'

import Form from './form'
import TagList from './tag-list'

export default React.createClass({

    getDefaultProps: function () {
        return {
            tags: [],
            onTagClick: function() {},
            onTagAdd: function() {},
            onTagClear: function() {}
        }
    },

    render: function () {
        return (
            <div className="component-tag-manager">
                <Form onTagAdd={this.props.onTagAdd} />
                <TagList tags={this.props.tags} onTagClick={this.props.onTagClick} onTagClear={this.props.onTagClear} />
            </div>
        )
    }
});