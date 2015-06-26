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
            <li className="component-tag-manager__list__item" data-item-id={this.props.tag.id}>
                <span className="component-tag-manager__list__item-inner">
                    <a href={"/#/tags/" + this.props.tag.id} className="component-tag-manager__list__item__link">{this.props.tag.title}</a>
                    <a className="component-tag-manager__list__item__remove-button glyphicon glyphicon-remove-sign" onClick={this._onRemove}></a>
                </span>
            </li>
        )
    }
});