import $ from 'jquery'
import _ from 'lodash'
import React from 'react'

import Tag from './tag'

export default React.createClass({

    getDefaultProps: function () {
        return {
            tags: [],
            onTagAdd: function () {
                return;
            }
        };
    },

    getInitialState: function () {
        return {
            tags: []
        };
    },

    componentWillReceiveProps: function (props) {
        this.setState({
            tags: _.values(props.tags)
        });
    },

    componentDidMount: function () {
        $(document).on('component.tag-manager.list.add', function (event, data) {
            this.props.onTagAdd(data, function (tags) {
                this.setState({
                    tags:tags.concat(this.state.tags)
                });
            }.bind(this));
        }.bind(this));

        $(document).on('component.tag-manager.list.remove', function (event, data) {
            this.props.onTagRemove(data, function () {
                this.setState({
                    tags: _.filter(this.state.tags, function(tag) {
                        return tag.id !== data.id;
                    })
                });
            }.bind(this));
        }.bind(this));
    },

    render: function () {
        return (
            <ul className="component-tag-manager__list">
                {this.state.tags.map(function (tag) {
                    return <Tag tag={tag} key={tag.id} />
                }.bind(this))}
            </ul>
        )
    }
});