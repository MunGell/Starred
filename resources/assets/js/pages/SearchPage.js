import React from 'react'
import Api from '../utils/api'

import RepositoryList from '../components/repository-list'
import TagList from '../components/tag-list'
import Paginator from '../components/paginator'

export default React.createClass({

    getInitialState: function () {
        return {
            tags: {},
            repositories: {}
        }
    },

    componentWillReceiveProps: function(newProps) {
        this._callApi(newProps.data.page);
    },

    _callApi: function(page) {
        page = page || this.props.data.page;
        Api.search(this.refs.searchField.getDOMNode().value, page, this._setData);
    },

    _onSearchChange: function () {
        var keyword = this.refs.searchField.getDOMNode().value;
        if (keyword.length > 3) {
            this._callApi();
        }
    },

    _setData: function (data) {
        if (this.isMounted()) {
            this.setState(data);
        }
    },

    _getPaginatorConfig: function() {
        var repos = this.state.repositories,
            tags = this.state.tags,
            to = Math.max(repos.to, tags.to);

        return {
            currentPage: repos.current_page,
            from: repos.from,
            to: to,
            perPage: repos.per_page
        }
    },

    render: function () {
        var paginatorConfig = this._getPaginatorConfig();
        return (
            <div className="page-search">
                <input type="text" placeholder="Search" ref="searchField" onChange={this._onSearchChange} />
                <RepositoryList data={this.state.repositories.data} root='/repositories/' />
                <TagList data={this.state.tags.data} root='/tags/' />
                <Paginator config={paginatorConfig} root='/search/' />
            </div>
        )
    }

});