import $ from 'jquery'
import React from 'react'

import Tag from './tag'

export default React.createClass({

    getDefaultProps: function() {
        return {
            tags: {}
        }
    },

    render: function () {
        return (
            <div>
                {Object.keys(this.props.tags).map(function (i) {
                    return <Tag tag={this.props.tags[i]} />
                }.bind(this))}
            </div>
        )
    }
});