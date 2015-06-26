import $ from 'jquery'
import React from 'react'

import Form from './form'
import TagList from './tag-list'

export default React.createClass({

    getDefaultProps: function () {
        return {
            tags: []
        }
    },

    render: function () {
        return (
            <div className="component-tag-manager">
                <Form />
                <TagList tags={this.props.tags} onTagAdd={this.props.onTagAdd} onTagRemove={this.props.onTagRemove} />
            </div>
        )
    }
});