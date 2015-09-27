import React from 'react'

export default React.createClass({

    _onSubmit: function (event) {
        event.preventDefault();
        this.props.onTagAdd(event.currentTarget[0].value);
        event.currentTarget[0].value = '';
    },

    render: function () {
        return (
            <div className="component-tag-manager__form">
                <form onSubmit={this._onSubmit}>
                    <input type="text" name="title" className="component-tag-manager__input" id="tagInput" placeholder="Add a tag"/>
                </form>
            </div>
        )
    }
});