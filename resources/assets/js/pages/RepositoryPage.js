import $ from 'jquery'
import React from 'react'

import Cookies from '../utils/cookies'
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

    _onTagAdd: function (data, callback) {
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': Cookies.getCookie('XSRF-TOKEN')
            }
        });

        $.post('/repositories/' + this.state.id + '/tags/add', data, callback);
    },

    _onTagRemove: function (id, callback) {
        $.ajaxSetup({
            headers: {
                'X-XSRF-TOKEN': Cookies.getCookie('XSRF-TOKEN')
            }
        });

        $.post('/repositories/' + this.state.id + '/tags/remove', {
            'tag': id
        }).done(callback);
    },

    render: function () {
        return (
            <div className="page-repository">
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