import React from 'react'
import Api from '../utils/api'

import Header from '../components/partials/header'
import TagManager from '../components/tag-manager'

export default React.createClass({

    getInitialState: function () {
        return {
            description: '',
            tags: []
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

    _onTagAdd: function (title) {
        Api.addTag(this.state.id, { title: title }, this._onStateTagAdd);
    },

    _onStateTagAdd: function (response) {
        var newState = this.state;
        newState.tags.push(response[0]);
        this.setState(newState);
    },

    _onTagClear: function (id) {
        Api.removeTag(this.state.id, { 'tag': id }, this._onStateTagRemove);
    },

    _onStateTagRemove: function(response) {
        var i, tag, newState = this.state;

        for (i in this.state.tags) {
            if (this.state.tags.hasOwnProperty(i)) {
                tag = this.state.tags[i];
                if (tag.id === parseInt(response.id)) {
                    newState.tags.splice(i, 1);
                    this.setState(newState);
                }
            }
        }
    },

    _onTagClick: function(id) {
        window.location.hash = '/tags/' + id;
    },

    render: function () {
        return (
            <div className="page-repository">
                <Header />
                <div className="page-repository__body">
                    <div className="page-repository__description">
                        <h1 className="page-repository__title">{this.state.name}</h1>
                        <p>{this.state.description}</p>
                    </div>
                    <div className="page-repository__tags">
                        <TagManager tags={this.state.tags} onTagClick={this._onTagClick} onTagAdd={this._onTagAdd} onTagClear={this._onTagClear} />
                    </div>
                </div>
            </div>
        )
    }

});