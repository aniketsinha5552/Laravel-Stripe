import axios from "axios";
import React, { useState } from "react";

const SubCard = ({ tier, user, currPlan }) => {

    const changeSub = async () => {
        if(currPlan?.id==tier?.id){
          let res = await axios.post("/unsubscribe", {
            user_id: user.id,
            plan: tier.id,
          });
          window.location.href = res.data.url;
        }else{
          let res = await axios.post("/subscribe", {
            user_id: user.id,
            plan: tier.id,
          });
          window.location.href = res.data.url;
        }

    };
    return (
        <div className="bg-slate-600 rounded-lg p-10 m-10 text-white text-center flex flex-col gap-10 w-64">
            <h1 className="text-2xl font-bold text-orange-400">{tier.name}</h1>
            <h2 className="text-xl">
                &#8377; {tier.price} <span className="text-sm">/ month</span>
            </h2>
            <p>{tier?.desc}</p>
            <button
                onClick={changeSub}
                className="mt-2 rounded-md p-2 bg-blue-600 hover:bg-blue-500"
            >
                {currPlan?.id==tier?.id ? "Unsubscribe" : "Subscribe"}
            </button>
        </div>
    );
};

export default SubCard;
