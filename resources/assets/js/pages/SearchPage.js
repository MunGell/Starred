import React from 'react'
import Api from '../utils/api'

import RepositoryList from '../components/repository-list'

export default React.createClass({

    getInitialState: function () {
        return {
            tags: {},
            repositories: {}
        }
    },

    componentDidMount: function () {
        Api.search(this.state.keyword, this._setData);
    },

    _setData: function (data) {
        if (this.isMounted()) {
            this.setState(data);
        }
    },

    _onSearchChange: function () {
        var keyword = this.refs.searchField.getDOMNode().value;
        if (keyword.length > 3) {
            Api.search(this.refs.searchField.getDOMNode().value, this._setData);
        }
    },

    render: function () {
        return (
            <div className="page-search">
                <input type="text" placeholder="Search" ref="searchField" onChange={this._onSearchChange} />
                <RepositoryList data={this.state.repositories.data} root='/repositories/' />
            </div>
        )
    }

});