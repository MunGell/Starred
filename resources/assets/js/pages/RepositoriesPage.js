import React from 'react'
import Api from '../utils/api'

import RepositoryList from '../components/repository-list'
import Paginator from '../components/paginator'

export default React.createClass({

    getInitialState: function () {
        return {
            data: []
        }
    },

    componentDidMount: function () {
        this._getApiData();
    },

    componentDidUpdate: function () {
        this._getApiData();
    },

    _getApiData: function() {
        Api.get('/repositories?page=' + this.props.data.page, this._setData);
    },

    _setData: function (data) {
        if (this.isMounted()) {
            this.setState(data);
        }
    },

    render: function () {
        return (
            <div className="page-repositories">
                <RepositoryList data={this.state.data} root='/repositories/' />
                <Paginator currentPage={this.state.current_page} lastPage={this.state.last_page} />
            </div>
        )
    }

});