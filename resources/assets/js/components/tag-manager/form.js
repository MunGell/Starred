import $ from 'jquery'
import React from 'react'

export default React.createClass({
    render: function () {
        return (
            <div className="component__tag-manager__form">
                <form className="form-inline" id="js-tag-form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                    <div className="input-group">
                        <label for="tagInput" className="sr-only">Add a tag</label>
                        <input type="text" name="title" className="form-control" id="tagInput" placeholder="Add a tag" />
                        <span className="input-group-btn">
                            <button className="btn btn-default" type="submit">Add</button>
                        </span>
                    </div>
                </form>
            </div>
        )
    }
});