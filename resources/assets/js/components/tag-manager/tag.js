import $ from 'jquery'
import React from 'react'

export default React.createClass({

    getDefaultProps: function () {
        return {
            tag: {
                id: 0,
                title: ''
            }
        }
    },

    _onRemove: function(event) {
        event.preventDefault();
        $(document).trigger('component.tag-manager.list.remove', this.props.tag);
    },

    render: function () {
        return (
            <li className="component-tag-manager__tag" data-item-id={this.props.tag.id}>
                <span className="component-tag-manager__tag-inner">
                    <a href={"/#/tags/" + this.props.tag.id} className="component-tag-manager__tag-link">{this.props.tag.title}</a>
                    <a className="component-tag-manager__tag-remove-button glyphicon glyphicon-remove-sign" onClick={this._onRemove}></a>
                </span>
            </li>
        )
    }
});