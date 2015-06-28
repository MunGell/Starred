import React from 'react'
import Api from '../utils/api'

import RepositoryList from '../components/repository-list'

export default React.createClass({

    getInitialState: function () {
        return {
            data: []
        }
    },

    componentDidMount: function () {
        Api.get('/tags/' + this.props.data.id, this._setData);
    },

    _setData: function (data) {
        if (this.isMounted()) {
            this.setState(data);
        }
    },

    render: function () {
        return (
            <div className="page-tag">
                <RepositoryList data={this.state.data} root='/repositories/' />
            </div>
        )
    }

});