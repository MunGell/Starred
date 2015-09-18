import React from 'react'
import Api from '../utils/api'

import Header from '../components/partials/header'
import RepositoryList from '../components/repository-list'
import Pagination from 'elemental/lib/components/Pagination'

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
            limit: 9,
            current_page: 1,
            last_page: 1,
            data: []
        }
    },

    componentDidMount: function () {
        this._getApiData();
    },

    componentWillReceiveProps: function (newProps) {
        this._getApiData(newProps.data.page);
    },

    _getApiData: function (page) {
        page = page || this.props.data.page;
        Api.get('/repositories?page=' + page, this._setData);
    },

    _setData: function (data) {
        if (this.isMounted()) {
            this.setState(data);
        }
    },

    _onPageChange: function (page) {
        this._getApiData(page);
    },

    render: function () {
        return (
            <div className="page-repositories">
                <Header />
                <RepositoryList data={this.state.data} root='/repositories/'/>

                <div className="page-search__paginator">
                    <Pagination currentPage={this.state.current_page}
                                onPageSelect={this._onPageChange}
                                pageSize={this.state.per_page}
                                total={this.state.total}
                                limit={this.state.limit}
                        />
                </div>
            </div>
        )
    }

});
