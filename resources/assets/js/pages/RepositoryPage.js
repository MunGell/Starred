import React from 'react'
import Api from '../utils/api'

import Header from '../components/partials/header'
import TagManager from '../components/tag-manager'

export default React.createClass({

    getInitialState: function () {
        return {
            data: {}
        }
    },

    componentDidMount: function () {
        Api.getRepository(this.props.data.id, this._setData);
    },

    _setData: function (data) {
        if (this.isMounted()) {
            this.setState(data);
        }
    },

    _onTagAdd: function (data, callback) {
        Api.addTag(this.state.id, data, callback);
    },

    _onTagRemove: function (id, callback) {
        Api.removeTag(this.state.id, { 'tag': id }, callback);
    },

    render: function () {
        return (
            <div className="page-repository">
                <Header />
                <div className="col-sm-5 col-sm-offset-2">
                    <h1>{this.state.name}</h1>
                    <p>{this.state.description}</p>
                </div>
                <div className="col-sm-3">
                    <div className="well">
                        <TagManager tags={this.state.tags} onTagAdd={this._onTagAdd} onTagRemove={this._onTagRemove} />
                    </div>
                </div>
            </div>
        )
    }

});