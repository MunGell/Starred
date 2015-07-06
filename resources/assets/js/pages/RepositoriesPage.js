import React from 'react'
import Api from '../utils/api'

import Header from '../components/partials/header'
import RepositoryList from '../components/repository-list'
import Paginator from '../components/paginator'

export default React.createClass({

    getDefaultProps: function () {
        return {
            data: {
                page: 1
            }
        }
    },

    getInitialState: function () {
        return {
            current_page: 1,
            last_page: 1,
            data: []
        }
    },

    componentDidMount: function () {
        this._getApiData();
    },

    componentWillReceiveProps: function(newProps) {
        this._getApiData(newProps.data.page);
    },

    _getApiData: function(page) {
        page = page || this.props.data.page;
        Api.get('/repositories?page=' + page, this._setData);
    },

    _setData: function (data) {
        if (this.isMounted()) {
            this.setState(data);
        }
    },

    render: function () {
        var paginatorConfig = {
            currentPage: this.state.current_page,
            lastPage: this.state.last_page
        };

        return (
            <div className="page-repositories">
                <Header />
                <RepositoryList data={this.state.data} root='/repositories/' />
                <div className="page-search__paginator">
                    <Paginator config={paginatorConfig} root='/repositories/' type='length-aware' />
                </div>
            </div>
        )
    }

});