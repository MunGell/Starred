import $ from 'jquery'
import React from 'react'

import TagManager from '../components/tag-manager'

export default React.createClass({

    getInitialState: function () {
        return {
            data: {}
        }
    },

    componentDidMount: function () {
        $.get('/repositories/' + this.props.data.id)
            .done(this._setData);
    },

    _setData: function (data) {
        if (this.isMounted()) {
            this.setState(data);
        }
    },

    render: function () {
        return (
            <div className="page-repository">
                <h1>{this.state.name}</h1>
                <h3>{this.state.description}</h3>
                <TagManager tags={this.state.tags} />
            </div>
        )
    }

});